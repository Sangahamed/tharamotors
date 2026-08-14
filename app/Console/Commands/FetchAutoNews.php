<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Article;
use Illuminate\Support\Str;
use Carbon\Carbon;
use SimplePie\SimplePie;

class FetchAutoNews extends Command
{
    protected $signature = 'fetch:auto-news';  // Important : utilisez les deux-points pour correspondre au Kernel
    protected $description = 'Récupère les actualités automobiles depuis Google News RSS et NewsAPI';

    public function handle()
    {
        $this->info('Début de la récupération des actualités...');

        // ---- Source 1 : Google News RSS ----
        $this->fetchFromRSS();

        // ---- Source 2 : NewsAPI (si clé configurée) ----
        if (env('NEWSAPI_KEY')) {
            $this->fetchFromNewsAPI();
        } else {
            $this->warn('Clé NEWSAPI_KEY non définie, ignoré.');
        }

        $this->info('Actualités mises à jour avec succès.');
    }

    private function fetchFromRSS()
{
    $feed = $this->makeFeed('https://news.google.com/rss/search?q=automobile&hl=fr&gl=FR&ceid=FR:fr');
    $items = $feed->get_items();

    foreach ($items as $item) {
        $title = $item->get_title();
        $description = strip_tags($item->get_description());
        $sourceUrl = $item->get_permalink();
        $published = $item->get_date('Y-m-d H:i:s') ?? now();
        $image = $this->extractImageFromFeedItem($item); // Correction ici

        Article::updateOrCreate(
            ['title' => $title],
            [
                'slug'         => Str::slug($title),
                'excerpt'      => Str::limit($description, 200),
                'content'      => $description,
                'source_url'   => $sourceUrl,
                'source_name'  => parse_url($sourceUrl, PHP_URL_HOST),
                'published_at' => $published,
                'image_url'    => $image,
                'category'     => $this->guessCategoryFromTitle($title),
            ]
        );
    }
}

    /**
     * Construit un flux SimplePie à partir de config/feeds.php.
     *
     * Remplace la façade willvincent/feeds, qui n'était qu'un emballage autour de
     * SimplePie et plafonnait à Laravel 12 (dernière version : v2.7.0, février 2025).
     * Les réglages restent lus depuis config/feeds.php pour ne rien changer au
     * comportement existant.
     */
    private function makeFeed(string $url): SimplePie
    {
        $config = config('feeds');

        $feed = new SimplePie();

        if ($config['cache.disabled']) {
            $feed->enable_cache(false);
        } else {
            $feed->set_cache_location($config['cache.location']);
            $feed->set_cache_duration($config['cache.life']);
        }

        $curlOptions = is_array($config['curl.options']) ? $config['curl.options'] : [];

        if ($config['ssl_check.disabled']) {
            $curlOptions[CURLOPT_SSL_VERIFYHOST] = false;
            $curlOptions[CURLOPT_SSL_VERIFYPEER] = false;
        }

        $feed->set_curl_options($curlOptions);

        if (! empty($config['user_agent'])) {
            $feed->set_useragent($config['user_agent']);
        }

        if (is_int($config['curl.timeout'])) {
            $feed->set_timeout($config['curl.timeout']);
        }

        $stripDisabled = $config['strip_html_tags.disabled'] ?? false;

        $feed->strip_htmltags(
            ! $stripDisabled && is_array($config['strip_html_tags.tags'] ?? null)
                ? $config['strip_html_tags.tags']
                : false
        );

        $feed->strip_attributes(
            ! $stripDisabled && is_array($config['strip_attribute.tags'] ?? null)
                ? $config['strip_attribute.tags']
                : false
        );

        $feed->set_feed_url($url);
        $feed->init();

        return $feed;
    }

    private function fetchFromNewsAPI()
    {
        $apiKey = env('NEWSAPI_KEY');
        if (!$apiKey) {
            $this->warn('Clé NEWSAPI_KEY non définie, ignoré.');
            return;
        }

        $keywords = ['automobile', 'voiture', 'BMW', 'Toyota', 'carburant'];
        $response = Http::withOptions(['verify' => false])->get('https://newsapi.org/v2/everything', [
            'q'          => implode(' OR ', $keywords),
            'language'   => 'fr',
            'sortBy'     => 'publishedAt',
            'pageSize'   => 50,
            'apiKey'     => $apiKey,
        ]);

        if ($response->failed()) {
            $this->error('Erreur API NewsAPI');
            return;
        }

        $articles = $response->json()['articles'] ?? [];

        foreach ($articles as $item) {
            // Éviter les doublons (par titre)
            $existing = Article::where('title', $item['title'])->first();
            if ($existing) continue;

            Article::create([
                'title'        => $item['title'],
                'slug'         => Str::slug($item['title']),
                'excerpt'      => $item['description'],
                'content'      => $item['content'] ?? $item['description'],
                'image_url'    => $item['urlToImage'],
                'source_url'   => $item['url'],
                'source_name'  => $item['source']['name'] ?? null,
                'published_at' => Carbon::parse($item['publishedAt'])->format('Y-m-d H:i:s'),
                'category'     => $this->guessCategoryFromTitle($item['title']),
            ]);
        }
    }

    private function extractFirstImageFromContent($html)
    {
        preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', $html, $match);
        return $match['src'] ?? null;
    }

    private function guessCategoryFromTitle($title)
    {
        $title = strtolower($title);
        if (str_contains($title, 'électrique') || str_contains($title, 'electrique')) return 'Électrique';
        if (str_contains($title, 'sport') || str_contains($title, 'performance')) return 'Sport';
        if (str_contains($title, 'carburant') || str_contains($title, 'prix')) return 'Carburant';
        if (str_contains($title, 'occasion') || str_contains($title, 'occasion')) return 'Occasion';
        return 'Actualité';
    }

    private function extractImageFromFeedItem($item)
{
    // 1. Vérifier les enclosures (balises <enclosure>)
    $enclosures = $item->get_enclosures();
    if ($enclosures && isset($enclosures[0])) {
        $image = $enclosures[0]->get_link();
        if ($image) return $image;
    }

    // 2. Vérifier les médias (media:content, media:thumbnail)
    if ($media = $item->get_item_tags('http://search.yahoo.com/mrss/', 'content')) {
        foreach ($media as $medium) {
            if (isset($medium['attribs']['']['url'])) {
                return $medium['attribs']['']['url'];
            }
        }
    }
    if ($thumb = $item->get_item_tags('http://search.yahoo.com/mrss/', 'thumbnail')) {
        if (isset($thumb[0]['attribs']['']['url'])) {
            return $thumb[0]['attribs']['']['url'];
        }
    }

    // 3. Chercher dans le contenu HTML
    return $this->extractFirstImageFromContent($item->get_content());
}
}
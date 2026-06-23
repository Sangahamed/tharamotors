<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== STATISTIQUES DE L\'APPLICATION ===');
        $this->line('');

        $brandCount = \App\Models\Brand::count();
        $articleCount = \App\Models\Article::count();
        $vehicleCount = \App\Models\Vehicle::count();

        $this->info("📊 Marques importées: {$brandCount}");
        $this->info("📰 Articles importés: {$articleCount}");
        $this->info("🚗 Véhicules disponibles: {$vehicleCount}");
        $this->line('');

        if ($brandCount > 0) {
            $this->info('=== ÉCHANTILLON DES MARQUES ===');
            $brands = \App\Models\Brand::take(5)->get();
            foreach ($brands as $brand) {
                $this->line("• {$brand->name}: {$brand->price}€ ({$brand->change}%)");
            }
            $this->line('');
        }

        if ($articleCount > 0) {
            $this->info('=== ÉCHANTILLON DES ARTICLES ===');
            $articles = \App\Models\Article::take(3)->get();
            foreach ($articles as $article) {
                $title = strlen($article->title) > 50 ? substr($article->title, 0, 47) . '...' : $article->title;
                $this->line("• {$title}");
            }
            $this->line('');
        }

        $this->info('✅ Import automatique des données terminé avec succès!');
    }
}

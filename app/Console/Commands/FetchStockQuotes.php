<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Brand;
use Illuminate\Support\Facades\Http;

class FetchStockQuotes extends Command
{
    protected $signature = 'fetch:stocks';
    protected $description = 'Récupère les cours et capitalisations des constructeurs';

    public function handle()
    {
        $apiKey = env('ALPHA_VANTAGE_KEY');
        $brands = [
            ['name' => 'Toyota', 'symbol' => 'TM'],
            ['name' => 'Tesla', 'symbol' => 'TSLA'],
            ['name' => 'BMW', 'symbol' => 'BMW.DEX'],
            ['name' => 'Volkswagen', 'symbol' => 'VOW3.DEX'],
            ['name' => 'Stellantis', 'symbol' => 'STLA'],
        ];

        foreach ($brands as $b) {
            $response = Http::get('https://www.alphavantage.co/query', [
                'function' => 'GLOBAL_QUOTE',
                'symbol'   => $b['symbol'],
                'apikey'   => $apiKey,
            ]);

            if ($response->successful()) {
                $data = $response->json()['Global Quote'] ?? [];
                if (!empty($data)) {
                    Brand::updateOrCreate(
                        ['name' => $b['name']],
                        [
                            'symbol'     => $b['symbol'],
                            'price'      => $data['05. price'] ?? null,
                            'change'     => $data['09. change'] ?? null,
                            'updated_at' => now(),
                        ]
                    );
                }
            }
            sleep(12); // respect de la limite de l'API gratuite
        }

        $this->info('Cours mis à jour.');
    }
}
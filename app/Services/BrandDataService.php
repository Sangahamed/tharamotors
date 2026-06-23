<?php

namespace App\Services;

use App\Models\Brand;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BrandDataService
{
    /**
     * Récupère les données des marques depuis une API externe
     */
    public function fetchBrandData()
    {
        try {
            // Simulation d'une API externe (remplacer par une vraie API comme Alpha Vantage, Yahoo Finance, etc.)
            $brandsData = $this->getMockBrandData();

            foreach ($brandsData as $brandData) {
                Brand::updateOrCreate(
                    ['name' => $brandData['name']],
                    [
                        'symbol' => $brandData['symbol'],
                        'price' => $brandData['price'],
                        'change' => $brandData['change'],
                        'market_cap' => $brandData['market_cap'],
                        'updated_at' => now(),
                    ]
                );
            }

            Log::info('Données des marques mises à jour automatiquement');
            return true;

        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des données des marques: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Données simulées (remplacer par une vraie API)
     */
    private function getMockBrandData()
    {
        // Simulation de données réelles avec variations aléatoires
        $baseData = [
            ['name' => 'BMW', 'symbol' => 'BMW.DE', 'price' => 85000, 'change' => rand(-50, 50) / 10, 'market_cap' => 50000000000],
            ['name' => 'AUDI', 'symbol' => 'AUDI.DE', 'price' => 65000, 'change' => rand(-50, 50) / 10, 'market_cap' => 40000000000],
            ['name' => 'CITROËN', 'symbol' => 'CITO.PA', 'price' => 45000, 'change' => rand(-50, 50) / 10, 'market_cap' => 25000000000],
            ['name' => 'TOYOTA', 'symbol' => 'TM', 'price' => 55000, 'change' => rand(-50, 50) / 10, 'market_cap' => 60000000000],
            ['name' => 'VOLKSWAGEN', 'symbol' => 'VOW.DE', 'price' => 50000, 'change' => rand(-50, 50) / 10, 'market_cap' => 35000000000],
            ['name' => 'MERCEDES', 'symbol' => 'MBG.DE', 'price' => 75000, 'change' => rand(-50, 50) / 10, 'market_cap' => 45000000000],
            ['name' => 'RENAULT', 'symbol' => 'RNO.PA', 'price' => 35000, 'change' => rand(-50, 50) / 10, 'market_cap' => 20000000000],
            ['name' => 'PEUGEOT', 'symbol' => 'PEUP.PA', 'price' => 40000, 'change' => rand(-50, 50) / 10, 'market_cap' => 22000000000],
        ];

        return $baseData;
    }

    /**
     * Méthode pour intégrer une vraie API (exemple avec Alpha Vantage)
     */
    private function fetchFromAlphaVantage($symbol)
    {
        $apiKey = config('services.alpha_vantage.key');
        $response = Http::get("https://www.alphavantage.co/query", [
            'function' => 'GLOBAL_QUOTE',
            'symbol' => $symbol,
            'apikey' => $apiKey,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            if (isset($data['Global Quote'])) {
                return [
                    'price' => (float) $data['Global Quote']['05. price'],
                    'change' => (float) $data['Global Quote']['09. change'],
                    'market_cap' => 0, // À calculer séparément si nécessaire
                ];
            }
        }

        return null;
    }
}

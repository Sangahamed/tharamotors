<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Brand;

class FetchAutoBrands extends Command
{
    protected $signature = 'fetch:auto-brands';
    protected $description = 'Récupère les données réelles des marques automobiles cotées en bourse via Alpha Vantage';

    // Liste des marques avec leurs symboles (uniquement celles qui sont cotées)
    private $brands = [
        ['name' => 'BMW', 'symbol' => 'BMW.DE'],
        ['name' => 'Volkswagen', 'symbol' => 'VOW.DE'],
        ['name' => 'Mercedes-Benz', 'symbol' => 'MBG.DE'],
        ['name' => 'Ford', 'symbol' => 'F'],
        ['name' => 'Toyota', 'symbol' => 'TM'],
        ['name' => 'Honda', 'symbol' => 'HMC'],
        ['name' => 'Nissan', 'symbol' => 'NSANY'],
        ['name' => 'Hyundai', 'symbol' => 'HYMTF'],
        ['name' => 'Mazda', 'symbol' => 'MZDAY'],
        ['name' => 'Volvo', 'symbol' => 'VOLVY'],
        ['name' => 'Tesla', 'symbol' => 'TSLA'],
        ['name' => 'Porsche', 'symbol' => 'POAHY'],
        ['name' => 'Ferrari', 'symbol' => 'RACE'],
        // Audi, Peugeot, Renault, Kia, Subaru, Lamborghini, Maserati ne sont pas cotées en tant que sociétés indépendantes (filiales ou non cotées)
    ];

    public function handle()
    {
        $this->info('Début de la récupération des données réelles des marques...');

        $apiKey = env('ALPHA_VANTAGE_KEY');
        if (!$apiKey) {
            $this->error('Clé ALPHA_VANTAGE_KEY non définie dans .env. Aucune donnée réelle ne peut être récupérée.');
            return 1;
        }

        $updatedCount = 0;
        foreach ($this->brands as $brand) {
            $name = $brand['name'];
            $symbol = $brand['symbol'];

            $this->info("Traitement de {$name} (symbole: {$symbol})...");
            $data = $this->fetchFromAlphaVantage($symbol, $apiKey);

            if ($data) {
                $this->updateBrand($name, $symbol, $data);
                $this->line("✅ {$name}: {$data['price']} ({$data['change']}%)");
                $updatedCount++;
            } else {
                $this->warn("❌ Échec pour {$name}, aucune donnée réelle récupérée. La marque reste inchangée.");
            }

            // Pause pour respecter les limites de l'API (5 appels par minute)
            sleep(12);
        }

        $this->info("Terminé. {$updatedCount} marques mises à jour avec des données réelles.");
        return 0;
    }

    /**
     * Récupère les données depuis Alpha Vantage.
     */
    private function fetchFromAlphaVantage($symbol, $apiKey)
    {
        try {
            $response = Http::timeout(10)->get('https://www.alphavantage.co/query', [
                'function' => 'GLOBAL_QUOTE',
                'symbol' => $symbol,
                'apikey' => $apiKey,
            ]);

            if (!$response->successful()) {
                $this->error("Erreur HTTP pour {$symbol}: " . $response->status());
                return null;
            }

            $data = $response->json();

            // Vérifier si la limite d'appels est atteinte
            if (isset($data['Note'])) {
                $this->error("Limite API Alpha Vantage atteinte: " . $data['Note']);
                return null;
            }

            $quote = $data['Global Quote'] ?? null;
            if (!$quote || !isset($quote['05. price'])) {
                $this->warn("Aucune donnée valide pour {$symbol}.");
                return null;
            }

            $price = (float) $quote['05. price'];
            $changePercent = str_replace(['%', '+'], '', $quote['10. change percent'] ?? '0%');
            $change = (float) $changePercent;

            return [
                'price' => round($price, 2),
                'change' => round($change, 2),
            ];
        } catch (\Exception $e) {
            $this->error("Exception pour {$symbol}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Met à jour ou crée la marque avec les données réelles.
     */
    private function updateBrand($name, $symbol, $data)
    {
        Brand::updateOrCreate(
            ['name' => $name],
            [
                'symbol' => $symbol,
                'price' => $data['price'],
                'change' => $data['change'],
                'market_cap' => $this->estimateMarketCap($name, $data['price']),
                'updated_at' => now(),
            ]
        );
    }

    /**
     * Estimation de la capitalisation boursière à partir de données connues ou du prix.
     */
    private function estimateMarketCap($brandName, $price)
    {
        // Données de référence pour les marques connues (en USD)
        $estimates = [
            'BMW' => 65000000000,
            'Volkswagen' => 80000000000,
            'Mercedes-Benz' => 70000000000,
            'Ford' => 50000000000,
            'Toyota' => 250000000000,
            'Honda' => 55000000000,
            'Nissan' => 40000000000,
            'Hyundai' => 45000000000,
            'Mazda' => 12000000000,
            'Volvo' => 28000000000,
            'Tesla' => 800000000000,
            'Porsche' => 35000000000,
            'Ferrari' => 55000000000,
        ];

        // Si connue, retourner la valeur fixe ; sinon utiliser une approximation basée sur le prix
        return $estimates[$brandName] ?? ($price * 1000000000);
    }
}
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\BrandDataService;

class UpdateBrandData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'brands:update-data {--force : Force la mise à jour même si récente}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Met à jour automatiquement les données des marques depuis internet';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Mise à jour des données des marques...');

        $service = new BrandDataService();
        $result = $service->fetchBrandData();

        if ($result) {
            $this->info('✅ Données des marques mises à jour avec succès!');
        } else {
            $this->error('❌ Erreur lors de la mise à jour des données des marques.');
            return 1;
        }

        return 0;
    }
}

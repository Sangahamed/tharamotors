<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Créer un utilisateur admin
        User::create([
            'name' => 'Admin THARA MOTORS',
            'email' => 'admin@tharamotors.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Créer un utilisateur test non-admin
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        $this->command->info('✅ Utilisateurs créés avec succès!');
        $this->command->info('');
        $this->command->warn('📧 Compte Admin:');
        $this->command->line('   Email: admin@tharamotors.com');
        $this->command->line('   Mot de passe: admin123');
        $this->command->info('');
        $this->command->warn('👤 Compte Test:');
        $this->command->line('   Email: test@example.com');
        $this->command->line('   Mot de passe: password123');
        $this->command->info('');
        $this->command->info('ℹ️  Les données des marques et articles seront récupérées automatiquement via les commandes Artisan.');
        $this->command->info('   - php artisan brands:update-data');
        $this->command->info('   - php artisan articles:update-data (à créer si nécessaire)');
    }
}
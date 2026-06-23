<?php

namespace Database\Factories;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    protected $model = Vehicle::class;

    public function definition(): array
    {
        $brands = ['BMW', 'Audi', 'Mercedes', 'Toyota', 'Honda', 'Ford', 'Volkswagen', 'Peugeot', 'Renault', 'Nissan'];
        $models = [
            'BMW' => ['Serie 3', 'Serie 5', 'X3', 'X5', 'i8'],
            'Audi' => ['A3', 'A4', 'A6', 'Q5', 'Q7'],
            'Mercedes' => ['Classe C', 'Classe E', 'GLC', 'GLE', 'S-Class'],
            'Toyota' => ['Corolla', 'Camry', 'RAV4', 'Highlander', 'Prius'],
            'Honda' => ['Civic', 'Accord', 'CR-V', 'Pilot', 'Fit'],
            'Ford' => ['Focus', 'Fiesta', 'Mustang', 'Explorer', 'F-150'],
            'Volkswagen' => ['Golf', 'Passat', 'Tiguan', 'Touareg', 'Polo'],
            'Peugeot' => ['208', '308', '3008', '5008', '508'],
            'Renault' => ['Clio', 'Megane', 'Captur', 'Kadjar', 'Talisman'],
            'Nissan' => ['Qashqai', 'Juke', 'Micra', 'X-Trail', 'Leaf']
        ];

        $brand = $this->faker->randomElement($brands);
        $model = $this->faker->randomElement($models[$brand]);

        return [
            'brand' => $brand,
            'model' => $model,
            'year' => $this->faker->numberBetween(2015, 2024),
            'price' => $this->faker->numberBetween(5000000, 25000000), // Prix en FCFA
            'mileage' => $this->faker->numberBetween(10000, 200000),
            'fuel_type' => $this->faker->randomElement(['Essence', 'Diesel', 'Hybride', 'Électrique']),
            'transmission' => $this->faker->randomElement(['Manuelle', 'Automatique', 'Semi-automatique']),
            'color' => $this->faker->randomElement(['Blanc', 'Noir', 'Gris', 'Bleu', 'Rouge', 'Argent', 'Vert']),
            'description' => $this->faker->paragraph(),
            'image_url' => $this->faker->imageUrl(800, 600, 'cars', true, $brand . ' ' . $model),
            'is_available' => $this->faker->boolean(80), // 80% de chance d'être disponible
        ];
    }
}
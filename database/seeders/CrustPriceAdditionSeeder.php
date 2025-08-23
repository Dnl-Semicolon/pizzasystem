<?php

namespace Database\Seeders;

use App\Models\Crust;
use App\Models\CrustPriceAddition;
use App\Models\PizzaSize;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CrustPriceAdditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $manualAdditions = [
            'New York Crust' => [
                'Small' => 0.00,
                'Medium' => 0.00,
                'Large' => 0.00,
            ],
            'Stuffed Crust' => [
                'Small' => 3.00,
                'Medium' => 5.00,
                'Large' => 7.00,
            ],
            'Crackin Thin' => [
                'Small' => null, // Not allowed, skip
                'Medium' => 0.00,
                'Large' => 0.00,
            ],
            'Cheesy Crust' => [
                'Small' => 1.50,
                'Medium' => 2.50,
                'Large' => 3.50,
            ],
        ];

        $sizes = PizzaSize::all()->keyBy('name');
        $crusts = Crust::all()->keyBy('name');

        foreach ($manualAdditions as $crustName => $additionsBySize) {
            $crust = $crusts[$crustName] ?? null;
            if (!$crust) continue;

            foreach ($additionsBySize as $sizeName => $amount) {
                $size = $sizes[$sizeName] ?? null;
                if (!$size || is_null($amount)) continue;

                CrustPriceAddition::factory()->create([
                    'crust_id' => $crust->id,
                    'pizza_size_id' => $size->id,
                    'price_addition' => $amount,
                ]);

            }

        }

    }
}

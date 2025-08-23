<?php

namespace Database\Seeders;

use App\Models\Pizza;
use App\Models\PizzaSize;
use App\Models\PizzaSizePrice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PizzaSizePriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sizes = PizzaSize::all()->keyBy('name');

        Pizza::with('product')->get()->each(function ($pizza) use ($sizes) {

            $manualPrices = [
                'Aloha Chicken' => [
                    'Small' => 14.59,
                    'Medium' => 35.99,
                    'Large' => 47.99,
                ],
                'Island Supreme' => [
                    'Small' => 16.99,
                    'Medium' => 39.39,
                    'Large' => 52.39,
                ],
                'Chicken Pepperoni' => [
                    'Small' => 14.59,
                    'Medium' => 35.99,
                    'Large' => 47.99,
                ],
                'Hawaiian Chicken' => [
                    'Small' => 14.59,
                    'Medium' => 35.99,
                    'Large' => 47.99,
                ],
                // Add more pizzas here...
            ];

            $name = $pizza->product->name;

            if (isset($manualPrices[$name])) {
                foreach ($manualPrices[$name] as $sizeName => $price) {
                    PizzaSizePrice::factory()->create([
                        'pizza_id' => $pizza->id,
                        'pizza_size_id' => $sizes[$sizeName]->id,
                        'base_price' => $price,
                    ]);
                }
            } else {
                $baseSmall = fake()->randomFloat(2, 13.00, 17.00);
                foreach (['Small', 'Medium', 'Large'] as $sizeName) {
                    $price = match ($sizeName) {
                        'Small' => $baseSmall,
                        'Medium' => $baseSmall + 3.00,
                        'Large' => $baseSmall + 6.00,
                    };

                    PizzaSizePrice::factory()->create([
                        'pizza_id' => $pizza->id,
                        'pizza_size_id' => $sizes[$sizeName]->id,
                        'base_price' => $price,
                    ]);
                }
            }
        });
    }
}

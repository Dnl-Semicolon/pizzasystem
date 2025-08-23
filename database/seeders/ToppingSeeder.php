<?php

namespace Database\Seeders;

use App\Models\Topping;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToppingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $toppings = [
            [
                'name' => 'Pepperoni',
                'price' => 1.50,
                'image_url' => 'assets/images/toppings/pepperoni.jpg',
            ],
            [
                'name' => 'Mushrooms',
                'price' => 1.00,
            ],
            [
                'name' => 'Extra Cheese',
                'price' => 1.75,
                'image_url' => 'assets/images/toppings/cheese.jpg',
            ],
        ];

        foreach ($toppings as $topping) {
            Topping::factory()->create($topping);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $pizzas = [
            [
                'name' => 'Aloha Chicken',
                'type' => 'pizza',
                'description' => "A pineapple lover's dream with juicy pineapple chunks and succulent shredded chicken!",
                'price' => 14.59,
                'is_active' => true,
                'image_url' => 'assets/images/products/aloha-chicken.jpg',
            ],
            [
                'name' => 'Island Supreme',
                'type' => 'pizza',
                'description' => "Tuna Chunks, crab meat, mushrooms, onions and pineapple on our Top Secret Sauce.",
                'price' => 16.99,
                'is_active' => true,
                'image_url' => 'assets/images/products/island-supreme.jpg',
            ],
            [
                'name' => 'Chicken Pepperoni',
                'type' => 'pizza',
                'description' => "Satisfy adults and kids alike with crispy and flavorful chicken pepperoni.",
                'price' => 14.59,
                'is_active' => true,
                'image_url' => 'assets/images/products/chicken-pepperoni.jpg',
            ],
            [
                'name' => 'Hawaiian Chicken',
                'type' => 'pizza',
                'description' => "With a perfect balance of sweet pineapple, savory chicken, and melty cheese, this pizza brings those island vibes straight to your kitchen.",
                'price' => 14.59,
                'is_active' => true,
                'image_url' => 'assets/images/products/hawaiian-chicken.jpg',
            ],
        ];
        foreach ($pizzas as $pizza) {
            Product::factory()->create($pizza);
        }
        Product::factory()->count(20)->create();
    }
}

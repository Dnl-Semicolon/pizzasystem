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
            [
                'name' => 'Deluxe Cheese',
                'type' => 'pizza',
                'description' => "Ultimate cheesy goodness with 30% extra mozzarella cheese on creamy garlic butter Top Secret Sauce!",
                'price' => 14.59,
                'is_active' => true,
                'image_url' => 'assets/images/products/deluxe-cheese.jpg',
            ],
        ];
        foreach ($pizzas as $pizza) {
            Product::factory()->create($pizza);
        }

        $products = [
            [
                'name' => 'Coca-Cola 330ml Can',
                'type' => 'drink',
                'description' => 'Classic cola in single-serve can. Best served cold with pizza.',
                'price' => 3.00,
                'is_active' => true,
                'image_url' => 'assets/images/products/coca_cola_can_330.jpg',
            ],
            [
                'name' => 'Sprite 330ml Can',
                'type' => 'drink',
                'description' => 'Lemon-lime soda, crisp and refreshing.',
                'price' => 3.00,
                'is_active' => true,
                'image_url' => 'assets/images/products/sprite_can_330.jpg',
            ],
            [
                'name' => 'Spritzer Natural Mineral Water 550ml',
                'type' => 'drink',
                'description' => 'Natural mineral water.',
                'price' => 2.90,
                'is_active' => true,
                'image_url' => 'assets/images/products/mineral_water_bottle_550.png',
            ],
            [
                'name' => 'Garlic Bread (4 slices)',
                'type' => 'side',
                'description' => 'Toasted baguette with garlic butter and herbs.',
                'price' => 5.90,
                'is_active' => true,
                'image_url' => 'assets/images/products/garlic_bread_4.jpg',
            ],
            [
                'name' => 'Cheesy Garlic Bread (4 slices)',
                'type' => 'side',
                'description' => 'Garlic bread topped with melted mozzarella.',
                'price' => 7.90,
                'is_active' => true,
                'image_url' => 'assets/images/products/cheesy_garlic_bread_4.jpg',
            ],
            [
                'name' => 'Chicken Wings (6 pcs)',
                'type' => 'side',
                'description' => 'Oven-baked wings with a side of chili dip.',
                'price' => 12.90,
                'is_active' => true,
                'image_url' => 'assets/images/products/chicken_wings_6.jpg',
            ],
            [
                'name' => 'Chocolate Lava Cake',
                'type' => 'dessert',
                'description' => 'Warm chocolate cake with molten center.',
                'price' => 7.90,
                'is_active' => true,
                'image_url' => 'assets/images/products/choc_lava_cake.jpg',
            ],
        ];

        foreach ($products as $product) {
            Product::factory()->create($product);
        }

//        Product::factory()->count(20)->create();
    }
}

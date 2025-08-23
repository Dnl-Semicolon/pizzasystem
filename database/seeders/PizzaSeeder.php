<?php

namespace Database\Seeders;

use App\Models\Crust;
use App\Models\PizzaSize;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PizzaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // For every pizza-type product, make a pizza record
        Product::where('type', 'pizza')->get()->each(function ($product) {
            $product->pizza()->create();
        });
    }
}

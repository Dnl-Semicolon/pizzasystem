<?php

namespace Database\Seeders;

use App\Models\PizzaSize;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PizzaSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sizes = [
            ['name' => 'Small'],
            ['name' => 'Medium'],
            ['name' => 'Large'],
        ];

        foreach ($sizes as $size) {
            PizzaSize::factory()->create($size);
        }
    }
}

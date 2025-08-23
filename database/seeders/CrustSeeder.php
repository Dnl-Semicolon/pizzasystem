<?php

namespace Database\Seeders;

use App\Models\Crust;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CrustSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $crusts = [
            [
                'name' => 'New York Crust',
                'image_url' => 'assets/images/crusts/new-york-crust.jpg',
            ],
            [
                'name' => 'Stuffed Crust',
                'image_url' => 'assets/images/crusts/stuffed-crust.jpg',
            ],
            [
                'name' => 'Crackin Thin',
                'image_url' => 'assets/images/crusts/crackin-thin.jpg',
            ],
            [
                'name' => 'Cheesy Crust',
                'image_url' => 'assets/images/crusts/cheesy-crust.jpg',
            ],
        ];

        foreach ($crusts as $crust) {
            Crust::factory()->create($crust);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::factory()->create([
            'customer_name' => 'Daniel Tan',
            'total_amount' => 153.27,
            'status' => 'processing',
        ]);
    }
}

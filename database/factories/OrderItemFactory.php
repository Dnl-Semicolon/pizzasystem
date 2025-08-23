<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => 1,
            'product_id' => Product::where('type', 'pizza')->inRandomOrder()->first()?->id ?? 1,
            'quantity' => 1,
            'unit_price' => 0.00,
            'final_price' => 0.00,
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PizzaOrderItemDetail>
 */
class PizzaOrderItemDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_item_id' => 1,
            'pizza_size_id' => 1,
            'crust_id' => 1,
            'base_price' => 0.00,
            'crust_addition' => 0.00,
            'toppings_total' => 0.00,
        ];
    }
}

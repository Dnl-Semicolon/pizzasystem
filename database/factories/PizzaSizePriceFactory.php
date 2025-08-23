<?php

namespace Database\Factories;

use App\Models\Pizza;
use App\Models\PizzaSize;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PizzaSizePrice>
 */
class PizzaSizePriceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pizza_id' => Pizza::inRandomOrder()->first()?->id ?? 1,
            'pizza_size_id' => PizzaSize::inRandomOrder()->first()?->id ?? 1,
            'base_price' => $this->faker->randomFloat(2, 13.00, 20.00),
        ];
    }
}

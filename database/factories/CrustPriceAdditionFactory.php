<?php

namespace Database\Factories;

use App\Models\Crust;
use App\Models\PizzaSize;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CrustPriceAddition>
 */
class CrustPriceAdditionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'crust_id' => Crust::inRandomOrder()->first()?->id ?? 1,
            'pizza_size_id' => PizzaSize::inRandomOrder()->first()?->id ?? 1,
            'price_addition' => 0.00, // Always overridden
        ];
    }
}

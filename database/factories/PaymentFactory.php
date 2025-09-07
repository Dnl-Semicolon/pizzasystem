<?php

namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        return [
            'payable_type' => $this->faker->word(),
            'payable_id' => $this->faker->randomNumber(),
            'currency' => $this->faker->word(),
            'amount' => $this->faker->randomNumber(),
            'method' => $this->faker->word(),
            'status' => $this->faker->word(),
            'captured_at' => Carbon::now(),
            'reference' => $this->faker->word(),
            'meta' => $this->faker->words(),
        ];
    }
}

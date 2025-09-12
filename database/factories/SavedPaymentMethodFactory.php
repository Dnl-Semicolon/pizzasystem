<?php

namespace Database\Factories;

use App\Models\SavedPaymentMethod;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SavedPaymentMethodFactory extends Factory
{
    protected $model = SavedPaymentMethod::class;

    public function definition(): array
    {
        $cardNumbers = [
            '4111111111111111', // Visa
            '4532015112830366', // Visa
            '5555555555554444', // Mastercard
            '5105105105105100', // Mastercard
            '378282246310005',  // Amex
            '371449635398431',  // Amex
        ];

        $cardNumber = $this->faker->randomElement($cardNumbers);
        $expMonth = $this->faker->numberBetween(1, 12);
        $expYear = $this->faker->numberBetween(2025, 2030);

        return [
            'user_id' => User::factory(),
            'label' => $this->faker->randomElement(['Personal Card', 'Work Card', 'Shopping Card', 'Backup Card', null]),
            'card_number' => $cardNumber,
            'cardholder_name' => $this->faker->name(),
            'exp_month' => $expMonth,
            'exp_year' => $expYear,
            'is_default' => $this->faker->boolean(20),
        ];
    }

    public function visa(): static
    {
        return $this->state(fn (array $attributes) => [
            'card_number' => '4111111111111111',
        ]);
    }

    public function mastercard(): static
    {
        return $this->state(fn (array $attributes) => [
            'card_number' => '5555555555554444',
        ]);
    }

    public function amex(): static
    {
        return $this->state(fn (array $attributes) => [
            'card_number' => '378282246310005',
        ]);
    }

    public function default(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_default' => true,
        ]);
    }
}
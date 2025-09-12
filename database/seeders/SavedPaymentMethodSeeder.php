<?php

namespace Database\Seeders;

use App\Models\SavedPaymentMethod;
use Illuminate\Database\Seeder;

class SavedPaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        SavedPaymentMethod::create([
            'user_id' => 1,
            'label' => 'Personal Visa',
            'card_number' => '4111111111111111',
            'cardholder_name' => 'Daniel Yee Kheng Tan',
            'exp_month' => 12,
            'exp_year' => 2027,
            'is_default' => true,
        ]);

        SavedPaymentMethod::create([
            'user_id' => 1,
            'label' => 'Work Card',
            'card_number' => '5555555555554444',
            'cardholder_name' => 'Daniel Yee Kheng Tan',
            'exp_month' => 8,
            'exp_year' => 2026,
            'is_default' => false,
        ]);

        SavedPaymentMethod::create([
            'user_id' => 1,
            'label' => 'Premium Amex',
            'card_number' => '378282246310005',
            'cardholder_name' => 'Daniel Yee Kheng Tan',
            'exp_month' => 3,
            'exp_year' => 2028,
            'is_default' => false,
        ]);

        SavedPaymentMethod::create([
            'user_id' => 1,
            'label' => null,
            'card_number' => '4532015112830366',
            'cardholder_name' => 'D Tan',
            'exp_month' => 6,
            'exp_year' => 2025,
            'is_default' => false,
        ]);
    }
}
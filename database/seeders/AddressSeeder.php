<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Address::create([
            'user_id' => 1,
            'label' => 'Home',
            'recipient_name' => 'Daniel Yee Kheng Tan',
            'phone' => '01124120654',
            'address_line_1' => '7',
            'address_line_2' => 'Solok Thean Tek',
            'city' => 'Air Itam',
            'state' => 'Penang',
            'postal_code' => '11400',
            'country' => 'Malaysia',
            'delivery_notes' => 'Call me when you arrive. Thanks',
            'is_default' => true,
        ]);
    }
}

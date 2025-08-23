<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\UserFactory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create users from friends data array
        foreach (UserFactory::getFriendsData() as $friendData) {
            User::create($friendData);
        }

        $this->call([
            ProductSeeder::class,
            PizzaSizeSeeder::class,
            CrustSeeder::class,
            ToppingSeeder::class,
            PizzaSeeder::class,
            PizzaSizePriceSeeder::class,
            CrustPriceAdditionSeeder::class,
            OrderSeeder::class,
            OrderItemSeeder::class,
            PizzaOrderItemDetailSeeder::class,
            PizzaOrderItemToppingSeeder::class,
            AddressSeeder::class,
        ]);
    }
}

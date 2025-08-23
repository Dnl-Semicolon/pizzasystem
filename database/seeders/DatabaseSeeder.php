<?php

namespace Database\Seeders;

use App\Models\User;
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
        User::factory()->daniel()->create();
        User::factory()->gooiKhaiYi()->create();
        User::factory()->lawJunYan()->create();
        User::factory()->chooZhengYi()->create();
        User::factory()->weeYiMing()->create();
        User::factory()->rickyGohEuXie()->create();
        User::factory()->fongWenYi()->create();
        User::factory()->limJiaYing()->create();
        User::factory()->limTziShe()->create();
        User::factory()->chengWinky()->create();
        User::factory()->fionTanXuanLing()->create();
        User::factory()->farhanIslamShafin()->create();
        User::factory()->chanelOoiAnnJoa()->create();
        User::factory()->jivenesWaraan()->create();
        User::factory()->leongKaiBin()->create();
        User::factory()->liangZenYin()->create();
        User::factory()->tehJyyJiun()->create();
        User::factory()->soonYenTeng()->create();
        User::factory()->ongChinWei()->create();

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
        ]);
    }
}

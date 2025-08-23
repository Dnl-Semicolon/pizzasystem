<?php

namespace Database\Seeders;

use App\Models\Crust;
use App\Models\OrderItem;
use App\Models\PizzaOrderItemDetail;
use App\Models\PizzaSize;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PizzaOrderItemDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orderItem = OrderItem::first();
        $size = PizzaSize::where('name', 'Medium')->first();
        $crust = Crust::where('name', 'Stuffed Crust')->first();

        PizzaOrderItemDetail::factory()->create([
            'order_item_id' => $orderItem->id,
            'pizza_size_id' => $size->id,
            'crust_id' => $crust->id,
            'base_price' => 35.99,
            'crust_addition' => 5.00,
            'toppings_total' => 2.50,
        ]);

        $orderItem = OrderItem::find(2);
        $size = PizzaSize::where('name', 'Large')->first();
        $crust = Crust::where('name', 'Cheesy Crust')->first();

        PizzaOrderItemDetail::factory()->create([
            'order_item_id' => $orderItem->id,
            'pizza_size_id' => $size->id,
            'crust_id' => $crust->id,
            'base_price' => 52.39,
            'crust_addition' => 2.50,
            'toppings_total' => 0.00,
        ]);
    }
}

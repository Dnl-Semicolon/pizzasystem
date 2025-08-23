<?php

namespace Database\Seeders;

use App\Models\OrderItem;
use App\Models\PizzaOrderItemTopping;
use App\Models\Topping;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PizzaOrderItemToppingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orderItem = OrderItem::first();
        $toppings = Topping::whereIn('name', ['Pepperoni', 'Mushrooms'])->get();

        foreach ($toppings as $topping) {
            PizzaOrderItemTopping::factory()->create([
                'order_item_id' => $orderItem->id,
                'topping_id' => $topping->id,
                'topping_price' => $topping->price,
            ]);
        }
    }
}

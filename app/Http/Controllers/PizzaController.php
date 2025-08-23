<?php

namespace App\Http\Controllers;

use App\Models\Crust;
use App\Models\CrustPriceAddition;
use App\Models\Pizza;
use App\Models\PizzaSize;
use App\Models\Topping;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PizzaController extends Controller
{
    /**
     * Display the pizzas.
     */
    public function index(): View
    {
        // 1. Get every pizza
        // 2. If they have no product image, set a placeholder image in its place
        $pizzas = Pizza::with('product')->get()->map(function ($pizza) {
            $pizza->product->image_url = $pizza->product->image_url ?? 'https://placehold.co/600x400.png';
            return $pizza;
        });

        return view('pizza.index', compact('pizzas'));
    }

    public function show($id)
    {
        // 1. Find that particular pizza by its id
        $pizza = Pizza::findOrFail($id);
        // 2. Get every topping
        // 3. If they have no product image, set a placeholder image in its place
        $toppings = Topping::all()->map(function ($topping) {
            $topping->image_url = $topping->image_url ?? 'https://placehold.co/600x400.png';
            return $topping;
        });
        // 4. Get every pizza size
        $sizes = PizzaSize::all();
        // 5. Get every pizza crust
        $crusts = Crust::all();
        // 6. Instantiate a price map
        $priceMap = [];
        $addOnMap = [];

        // 7. For each pizza size, each knows as "$size"
        foreach ($sizes as $size) {
            // 8. For each pizza crust, each knows as "$crust"
            foreach ($crusts as $crust) {
                // 9. Instantiate a $base, which serves to
                //    A pizza has many 'Size Prices'
                //    Typically, 1 pizza has 3 sizes  with
                //    3 prices.
                //    In  the  beginning,   you  have  the
                //    current pizza. Then,  you  have  the
                //    first size. Use the current size  to
                //    pinpoint  the  accurate  Pizza  Size
                //    Price, then extract  its  base_price
                //    into $base.
                $base = $pizza->sizePrices()
                    ->where('pizza_size_id', $size->id)
                    ->first()?->base_price;
                // 10. Each   crust   and    pizza    size
                //     combination has a price_addition.
                //     Look  for  the  right  Crust  Price
                //     Addition by using the where  clause
                //     on both crust_id and  pizza_size_id
                //     and  extract  that   price_addition
                //     into the $addon variable.
                $addon = CrustPriceAddition::where('crust_id', $crust->id)
                    ->where('pizza_size_id', $size->id)
                    ->first()?->price_addition;
                // 11. Hopefully by now, we have  a  $base
                //     and a $addon. Check if they're  not
                //     null.  If so,  add  the  values  of
                //     $base and $addon together. Use a 2-
                //     dimensional    array    known    as
                //     $priceMap  that  was   instantiated
                //     earlier to store the value. Repeat.
                if (!is_null($base) && !is_null($addon)) {
                    $priceMap[$size->id][$crust->id] = $base + $addon;
                    $addOnMap[$size->id][$crust->id] = $addon;
                }
            }
        }
        // 12. When the price map has been configured,
        //     return the view alongside  the  current
        //     pizza ('$pizza'),  all   the   toppings
        //     ('$toppings'), all the sizes ('$sizes')
        //     , all the crusts ('$crusts'),  and  the
        //     derived price map ('$priceMap').
        return view('pizza.show', compact('pizza', 'toppings', 'sizes', 'crusts', 'priceMap', 'addOnMap'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Crust;
use App\Models\CrustPriceAddition;
use App\Models\Pizza;
use App\Models\PizzaSize;
use App\Models\Product;
use App\Models\Topping;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * Display the cart.
     */
    public function index(): View
    {
        $cart = session('cart', []);
        $hydratedCart = [];

        foreach ($cart as $item) {
            if ($item['type'] === 'pizza') {
                $pizza = Pizza::with('product')->find($item['pizza_id']);
                $size = PizzaSize::find($item['size_id']);
                $crust = Crust::find($item['crust_id']);

                // 🧠 Parse the topping IDs from strings like "1-1.50"
                $toppingIds = collect($item['toppings'] ?? [])
                    ->map(fn($t) => explode('-', $t)[0]) // get just the ID
                    ->filter() // remove null/empty
                    ->map(fn($id) => (int) $id) // cast to int
                    ->toArray();

                // 🔎 Fetch topping names using Eloquent
                $toppingNames = Topping::whereIn('id', $toppingIds)->pluck('name')->toArray();

                $hydratedCart[] = [
                    'type' => 'pizza',
                    'product_name' => $pizza?->product->name ?? 'Unknown Pizza',
                    'size' => $size?->name ?? 'Unknown',
                    'crust' => $crust?->name ?? 'Unknown',
                    'toppings' => $toppingNames,
                    'quantity' => $item['quantity'],

                    'unit_price' => $item['unit_price'],
                    'total_price' => $item['total_price'],
                ];
            } elseif ($item['type'] === 'product') {
                $product = Product::find($item['product_id']);

                $hydratedCart[] = [
                    'type' => 'product',
                    'product_name' => $product?->name ?? 'Unknown Item',
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total_price' => $item['total_price'],
                    'toppings' => [],
                    'size' => null,
                    'crust' => null,
                ];
            }
        }

        return view('cart.index', ['cart' => $hydratedCart]);
    }

    public function addToCart(Request $request)
    {
        $cart = session()->get('cart', []);

        $quantity = (int) $request->input('quantity', 1);

        if ($request->has('pizza_id')) {
            // 🍕 Customized Pizza

            $pizza = Pizza::findOrFail($request->pizza_id);
            $productId = $pizza->product->id;

            $sizeId = null;
            $crustId = null;

            if ($request->filled('variant')) {
                [$sizeId, $crustId] = explode('_', $request->input('variant'));
            } else {
                $sizeId = $request->input('size_id');
                $crustId = $request->input('crust_id');
            }

            // Get base price
            $basePrice = $pizza->sizePrices()
                ->where('pizza_size_id', $sizeId)
                ->first()?->base_price ?? 0;

            // Get crust addon
            $addon = CrustPriceAddition::where('crust_id', $crustId)
                ->where('pizza_size_id', $sizeId)
                ->first()?->price_addition ?? 0;

            // Get toppings
            $toppingTotal = 0;
            $toppingIds = [];

            $matched = false;
            $toppingsJson = $request->input('toppingsJson', '[]'); // default to empty array
            $toppings = collect(json_decode($toppingsJson, true))
                ->sortBy('name')
                ->values()
                ->all();

            foreach ($cart as &$item) {
                $itemToppings = collect(json_decode($item['toppingsNames'], true))
                    ->sortBy('name')
                    ->values()
                    ->all();

                if (
                    $item['type'] === 'pizza' &&
                    $item['pizza_id'] == $request->pizza_id &&
                    $item['size_id'] == $sizeId &&
                    $item['crust_id'] == $crustId &&
                    $itemToppings == $toppings
                ) {
                    $item['quantity'] += $quantity;
                    $item['total_price'] = $item['unit_price'] * $item['quantity'];
                    $matched = true;
                    break;
                }
            }

            if (!$matched) {
                // Compute toppingsTotal
                $toppingsTotal = 0.00;
                if (is_array($request->toppings)) {
                    foreach ($request->toppings as $topping) {
                        // Expecting format "id-price", e.g. "2-1.00"
                        [$id, $price] = explode('-', $topping);
                        $toppingsTotal += (float) $price;
                    }
                    $toppingsTotal = round($toppingsTotal, 2);
                }

                if (is_array($request->toppings)) {
                    foreach ($request->toppings as $raw) {
                        [$id, $price] = explode('-', $raw);
                        $toppingTotal += (float) $price;
                        $toppingIds[] = $id;
                    }

                    $toppingNames = Topping::whereIn('id', $toppingIds)->pluck('name')->toArray();
                }

                // Final price calculation
                $unitPrice = round($basePrice + $addon + $toppingTotal, 2);
                $totalPrice = $unitPrice * $quantity;


                $cart[] = [
                    'type' => 'pizza',
                    'product_id' => $productId,
                    'pizza_id' => $request->pizza_id,
                    'size_id' => $sizeId,
                    'crust_id' => $crustId,
                    'add_on' => $addon,
                    'base_price' => round((float) $request->price, 2),
//                    'unit_price' => round((float) $request->unit_price, 2),
                    'unit_price' => $unitPrice,
//                    'total_price' => round((float) $request->total_price, 2),
                    'total_price' => $totalPrice,
                    'quantity' => $quantity,
                    'toppings' => $request->toppings,
//                    'toppingsNames' => $request->toppingsJson,
                    'toppingsNames' => $toppingsJson,
//                    'toppings_total' => $toppingsTotal,
                    'toppings_total' => $toppingTotal,
                ];
            }

        } elseif ($request->has('product_id')) {
            // 🧃 Simple Product
            $product = Product::findOrFail($request->product_id);

            $cart[] = [
                'type' => 'product',
                'product_id' => $product->id,
                'name' => $product->name,
                'quantity' => $quantity,
                'unit_price' => round((float) $product->price, 2),
                'total_price' => round((float) $product->price * $quantity, 2, 2),
            ];
        }

        session(['cart' => $cart]);

        return redirect()->route('orders.create')->with('success', 'Item added to cart!');
    }
}
//                    'type' => 'pizza',
//                    'product_id' => $productId,
//                    'pizza_id' => $request->pizza_id,
//                    'size_id' => $sizeId,
//                    'crust_id' => $crustId,
//                    'add_on' => $request->add_on_price,
//                    'base_price' => round((float) $request->price, 2),
////                    'unit_price' => round((float) $request->unit_price, 2),
//                    'unit_price' => $unitPrice,
////                    'total_price' => round((float) $request->total_price, 2),
//                    'total_price' => $totalPrice,
//                    'quantity' => $quantity,
//                    'toppings' => $request->toppings,
////                    'toppingsNames' => $request->toppingsJson,
//                    'toppingsNames' => $toppingNames,
////                    'toppings_total' => $toppingsTotal,
//                    'toppings_total' => $toppingTotal,

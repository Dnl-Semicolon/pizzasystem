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

            // Normalize toppings for comparison
            $toppingsJson = $request->input('toppingsJson', '[]');
            $toppings = collect(json_decode($toppingsJson, true) ?: [])
                ->sortBy('name')->values()->all();

            // Try to find a matching existing item and update it
            $matched = false;
            foreach ($cart as $idx => $item) {
                $itemToppings = collect(json_decode($item['toppingsNames'] ?? '[]', true) ?: [])
                    ->sortBy('name')->values()->all();

                if (
                    ($item['type'] ?? null) === 'pizza' &&
                    ($item['pizza_id'] ?? null) == $request->pizza_id &&
                    ($item['size_id'] ?? null) == $sizeId &&
                    ($item['crust_id'] ?? null) == $crustId &&
                    $itemToppings == $toppings
                ) {
                    $cart[$idx]['quantity'] = (int) ($cart[$idx]['quantity'] ?? 0) + $quantity;
                    $cart[$idx]['total_price'] = round($cart[$idx]['unit_price'] * $cart[$idx]['quantity'], 2);
                    $matched = true;
                    break;
                }
            }

            if (!$matched) {
                // Compute toppings totals & names (from "id-price" inputs)
                $toppingTotal = 0.00;
                $toppingIds = [];
                if (is_array($request->toppings)) {
                    foreach ($request->toppings as $raw) {
                        [$id, $price] = explode('-', $raw);
                        $toppingTotal += (float) $price;
                        $toppingIds[] = $id;
                    }
                }
                $toppingNames = $toppingIds ? Topping::whereIn('id', $toppingIds)->pluck('name')->toArray() : [];

                // Final price
                $unitPrice = round($basePrice + $addon + $toppingTotal, 2);
                $totalPrice = round($unitPrice * $quantity, 2);

                $cart[] = [
                    'type'           => 'pizza',
                    'product_id'     => $productId,
                    'pizza_id'       => $request->pizza_id,
                    'size_id'        => $sizeId,
                    'crust_id'       => $crustId,
                    'add_on'         => $addon,
                    'base_price'     => round((float) $basePrice, 2),
                    'unit_price'     => $unitPrice,
                    'total_price'    => $totalPrice,
                    'quantity'       => $quantity,
                    'toppings'       => $request->toppings,     // raw "id-price" strings
                    'toppingsNames'  => $toppingsJson,          // normalized JSON (for match)
                    'toppings_total' => round($toppingTotal, 2),
                    // optional: store resolved names if you render them
                    // 'toppings_label' => $toppingNames,
                ];
            }

        } elseif ($request->has('product_id')) {
            // 🧃 Simple Product
            $product = Product::findOrFail($request->product_id);
            $cart[] = [
                'type'        => 'product',
                'product_id'  => $product->id,
                'name'        => $product->name,
                'quantity'    => $quantity,
                'unit_price'  => round((float) $product->price, 2),
                'total_price' => round((float) $product->price * $quantity, 2),
            ];
        }

        session(['cart' => $cart]);

        return redirect()->route('orders.create')->with('success', 'Item added to cart!');
    }


}

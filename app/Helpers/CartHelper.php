<?php

namespace App\Helpers;

use App\Models\Crust;
use App\Models\Pizza;
use App\Models\PizzaSize;
use App\Models\Product;
use App\Models\Topping;

class CartHelper
{
    public static function getHydratedCart(): array
    {
        $cart = session('cart', []);
        $hydratedCart = [];

        foreach ($cart as $item) {
            if ($item['type'] === 'pizza') {
                $hydratedCart[] = self::hydratePizzaItem($item);
            } elseif ($item['type'] === 'product') {
                $hydratedCart[] = self::hydrateProductItem($item);
            }
        }

        return $hydratedCart;
    }

    private static function hydratePizzaItem(array $item): object
    {
        $pizza = Pizza::with('product')->find($item['pizza_id']);
        $size = PizzaSize::find($item['size_id']);
        $crust = Crust::find($item['crust_id']);

        // Parse topping IDs from strings like "1-1.50"
        $toppingIds = collect($item['toppings'] ?? [])
            ->map(fn($t) => explode('-', $t)[0])
            ->filter()
            ->map(fn($id) => (int) $id)
            ->toArray();

        $toppings = Topping::whereIn('id', $toppingIds)->get();

        return (object) [
            'type' => 'pizza',
            'product_name' => $pizza?->product->name ?? 'Unknown Pizza',
            'pizza' => $pizza,
            'size' => $size,
            'crust' => $crust,
            'toppings' => $toppings,
            'quantity' => $item['quantity'],
            'unit_price' => $item['unit_price'],
            'total_price' => $item['total_price'],
        ];
    }

    private static function hydrateProductItem(array $item): object
    {
        $product = Product::find($item['product_id']);

        return (object) [
            'type' => 'product',
            'product_name' => $product?->name ?? 'Unknown Item',
            'product' => $product,
            'quantity' => $item['quantity'],
            'unit_price' => $item['unit_price'],
            'total_price' => $item['total_price'],
            'toppings' => collect(),
            'size' => null,
            'crust' => null,
        ];
    }

    public static function getCartTotal(): float
    {
        $cart = session('cart', []);
        return collect($cart)->sum('total_price');
    }

    public static function getCartCount(): int
    {
        $cart = session('cart', []);
        return collect($cart)->sum('quantity');
    }

    public static function isCartEmpty(): bool
    {
        $cart = session('cart', []);
        return empty($cart);
    }
}
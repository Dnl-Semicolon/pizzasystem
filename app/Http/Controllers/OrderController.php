<?php

namespace App\Http\Controllers;

use App\Models\Crust;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Pizza;
use App\Models\PizzaOrderItemDetail;
use App\Models\PizzaOrderItemTopping;
use App\Models\PizzaSize;
use App\Models\Product;
use App\Models\Topping;
use App\Helpers\CartHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::all();
        return view('order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::with([
            'pizza.sizePrices.size', // eager load prices with size info
        ])->get();

        // Extract pizza-related product data with prices
        $pizzasWithPrices = $products->filter(fn ($p) => $p->type === 'pizza')
            ->mapWithKeys(function ($product) {
                return [$product->id => [
                    'name' => $product->name,
                    'prices' => $product->pizza->sizePrices->map(function ($price) {
                        return [
                            'size' => $price->size->name,
                            'price' => $price->base_price,
                        ];
                    })->values()
                ]];
            });

        $crusts = Crust::all();

        $hydratedCart = CartHelper::getHydratedCart();

        return view('order.create', compact('products', 'pizzasWithPrices', 'crusts'), ['cart' => $hydratedCart]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Check if cart is empty using helper
        if (CartHelper::isCartEmpty()) {
            return redirect()->back()->with('error', 'Cart is empty.');
        }

        // 2. Get the cart session object
        $cart = session('cart', []);

        // 3. Create an order
        $order = Order::create([
            'customer_name' => Auth::user()->name,
            'total_amount' => 0.00, // Will calculate below
            'status' => 'processing',
        ]);

        $grandTotal = 0;

        foreach ($cart as $item) {

            $pizza = null;
            $productId = null;

            if ($item['type'] === 'pizza') {
                $pizza = Pizza::with('product')->find($item['pizza_id']);
                $productId = $pizza?->product_id ?? null;
            } elseif ($item['type'] === 'product') {
                $productId = $item['product_id'];
            }

            // Create Order Item (applies to both pizza and product)
            $orderItem = new OrderItem([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'final_price' => $item['total_price'],
            ]);
            $orderItem->save();

            $grandTotal += $item['total_price'];

            // If it's a pizza, add detail + toppings
            if ($item['type'] === 'pizza') {
                PizzaOrderItemDetail::create([
                    'order_item_id' => $orderItem->id,
                    'pizza_size_id' => $item['size_id'],
                    'crust_id' => $item['crust_id'],
                    'base_price' => $item['base_price'],
                    'crust_addition' => $item['add_on'],
                    'toppings_total' => $item['toppings_total'],
                ]);

                if (!empty($item['toppings'])) {
                    foreach ($item['toppings'] as $toppingString) {
                        [$toppingId, $toppingPrice] = explode('-', $toppingString);
                        PizzaOrderItemTopping::create([
                            'order_item_id' => $orderItem->id,
                            'topping_id' => $toppingId,
                            'topping_price' => $toppingPrice,
                        ]);
                    }
                }
            }
        }

        $order->total_amount = $grandTotal;
        $order->save();

        session()->forget('cart');

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Order created successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load([
            'items.product',
            'items.pizzaDetails.size',
            'items.pizzaDetails.crust',
            'items.toppings.topping'
        ]);

        return view('order.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}

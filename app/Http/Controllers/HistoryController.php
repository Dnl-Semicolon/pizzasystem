<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HistoryController extends Controller
{
    /**
     * Display the order history.
     */
    public function index(Request $request): View
    {
        $query = Order::where('customer_name', Auth::user()->name)
            ->with([
                'items.product',
                'items.pizzaDetails.size',
                'items.pizzaDetails.crust',
                'items.toppings.topping'
            ])
            ->orderBy('created_at', 'desc');

        // Add status filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Add search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('items.product', function ($productQuery) use ($search) {
                      $productQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->paginate(10)->withQueryString();

        return view('history.index', compact('orders'));
    }
}

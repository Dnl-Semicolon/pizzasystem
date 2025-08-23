<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pizza;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PizzaController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::query()
            ->where('type', 'pizza')
            ->whereHas('pizza');

        // Search
        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Status
        if ($status = $request->input('status')) {
            if ($status === 'active') $query->where('is_active', true);
            elseif ($status === 'inactive') $query->where('is_active', false);
            elseif ($status === 'trashed') $query->onlyTrashed(); // if Product uses SoftDeletes
        }

        // Sorting
        if ($sort = $request->input('sort')) {
            match ($sort) {
                'name_asc'   => $query->orderBy('name', 'asc'),
                'name_desc'  => $query->orderBy('name', 'desc'),
                'price_asc'  => $query->orderBy('price', 'asc'),
                'price_desc' => $query->orderBy('price', 'desc'),
                'newest'     => $query->orderBy('created_at', 'desc'),
                'oldest'     => $query->orderBy('created_at', 'asc'),
                default      => null,
            };
        }

        $perPage  = $request->input('per_page', 10);
        $products = $query->paginate($perPage)->withQueryString();

        return view('admin.pizzas.index', compact('products'));
    }
}

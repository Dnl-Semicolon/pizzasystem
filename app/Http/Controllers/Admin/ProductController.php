<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::query();

        // Search filter
        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Type filter
        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        // Status filter
        if ($status = $request->input('status')) {
            if ($status === 'active') {
                $query->where('is_active', true);
            } elseif ($status === 'inactive') {
                $query->where('is_active', false);
            } elseif ($status === 'trashed') {
                $query->onlyTrashed(); // works if model uses SoftDeletes
            }
        }

        // Sorting
        if ($sort = $request->input('sort')) {
            match ($sort) {
                'name_asc'  => $query->orderBy('name', 'asc'),
                'name_desc' => $query->orderBy('name', 'desc'),
                'price_asc' => $query->orderBy('price', 'asc'),
                'price_desc'=> $query->orderBy('price', 'desc'),
                'newest'    => $query->orderBy('created_at', 'desc'),
                'oldest'    => $query->orderBy('created_at', 'asc'),
                default     => null,
            };
        }

        // Per page (default 10)
        $perPage = $request->input('per_page', 10);

        // Get paginated results and preserve query string
        $products = $query->paginate($perPage)->withQueryString();

        return view('admin.products.index', compact('products'));
    }
}

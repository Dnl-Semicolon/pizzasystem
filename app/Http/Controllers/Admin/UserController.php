<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::query();

        // Search filter
        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Per page (default 10)
        $perPage = $request->input('per_page', 10);

        // Get paginated results and preserve query string
        $users = $query->paginate($perPage)->withQueryString();

        return view('admin.users.index', compact('users'));
    }
}

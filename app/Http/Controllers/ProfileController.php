<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $activeTab = $request->get('tab', 'profile');
        $user = $request->user();
        
        // Load order data for orders tab
        $orders = collect();
        $orderStats = [
            'total_orders' => 0,
            'total_spent' => 0,
            'favorite_pizza' => null
        ];
        
        // Load billing data for billing tab
        $recentPayments = collect();
        $billingStats = [
            'total_payments' => 0,
            'total_spent' => 0
        ];
        
        if ($activeTab === 'orders') {
            $orders = Order::where('customer_name', $user->name)
                ->with([
                    'items.product',
                    'items.pizzaDetails.size',
                    'items.pizzaDetails.crust',
                    'items.toppings.topping'
                ])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
                
            // Calculate stats
            $allOrders = Order::where('customer_name', $user->name)->get();
            $orderStats['total_orders'] = $allOrders->count();
            $orderStats['total_spent'] = $allOrders->sum('total_amount');
            
            // Find favorite pizza
            $pizzaCounts = $allOrders->flatMap(function ($order) {
                return $order->items->where('product.type', 'pizza');
            })->groupBy('product.name')->map->count()->sortDesc();
            
            $orderStats['favorite_pizza'] = $pizzaCounts->keys()->first();
        }
        
        if ($activeTab === 'billing') {
            // Get recent payments for this user through their orders
            $recentPayments = Payment::where('payable_type', 'order')
                ->whereHas('order', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->with(['order'])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
            
            // Calculate billing statistics
            $allUserPayments = Payment::where('payable_type', 'order')
                ->whereHas('order', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })->where('status', 'captured')->get();
            
            $billingStats['total_payments'] = $allUserPayments->count();
            $billingStats['total_spent'] = $allUserPayments->sum('amount');
        }
        
        return view('profile.edit', [
            'user' => $user,
            'activeTab' => $activeTab,
            'orders' => $orders,
            'orderStats' => $orderStats,
            'recentPayments' => $recentPayments,
            'billingStats' => $billingStats,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Update the user's profile photo.
     */
    public function updatePhoto(Request $request): RedirectResponse
    {
        $request->validate([
            'profile_photo' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $user = $request->user();

        // Delete old profile photo if it exists
        if ($user->profile_photo_path && file_exists(public_path($user->profile_photo_path))) {
            unlink(public_path($user->profile_photo_path));
        }

        // Store the new photo
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = Str::slug($user->name) . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Move file to public/assets/images/profile_photos/
            $destinationPath = public_path('assets/images/profile_photos');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            $file->move($destinationPath, $filename);
            
            // Update user's profile photo path
            $user->profile_photo_path = 'assets/images/profile_photos/' . $filename;
            $user->save();
        }

        return Redirect::route('profile.edit', ['tab' => 'photo'])->with('status', 'photo-updated');
    }

    /**
     * Delete the user's profile photo.
     */
    public function deletePhoto(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->profile_photo_path && file_exists(public_path($user->profile_photo_path))) {
            unlink(public_path($user->profile_photo_path));
        }

        $user->profile_photo_path = null;
        $user->save();

        return Redirect::route('profile.edit', ['tab' => 'photo'])->with('status', 'photo-deleted');
    }
}

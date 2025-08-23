<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{

    public function index()
    {
        $addresses = Auth::user()->addresses()->orderBy('is_default', 'desc')->get();
        return view('addresses.index', compact('addresses'));
    }

    public function create()
    {
        return view('addresses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'nullable|string|max:255',
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address_line_1' => 'required|string',
            'address_line_2' => 'nullable|string',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'country' => 'required|string|max:255',
            'delivery_notes' => 'nullable|string',
            'is_default' => 'boolean',
        ]);

        $validated['user_id'] = Auth::id();

        // If this is set as default, unset other defaults
        if ($validated['is_default'] ?? false) {
            Auth::user()->addresses()->update(['is_default' => false]);
        }

        Address::create($validated);

        return redirect()->route('addresses.index')->with('success', 'Address added successfully!');
    }

    public function show(Address $address)
    {
        // Ensure user owns this address
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        return view('addresses.show', compact('address'));
    }

    public function edit(Address $address)
    {
        // Ensure user owns this address
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        return view('addresses.edit', compact('address'));
    }

    public function update(Request $request, Address $address)
    {
        // Ensure user owns this address
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'label' => 'nullable|string|max:255',
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address_line_1' => 'required|string',
            'address_line_2' => 'nullable|string',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'country' => 'required|string|max:255',
            'delivery_notes' => 'nullable|string',
            'is_default' => 'boolean',
        ]);

        // If this is set as default, unset other defaults
        if ($validated['is_default'] ?? false) {
            Auth::user()->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
        }

        $address->update($validated);

        return redirect()->route('addresses.index')->with('success', 'Address updated successfully!');
    }

    public function destroy(Address $address)
    {
        // Ensure user owns this address
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $address->delete();

        return redirect()->route('addresses.index')->with('success', 'Address deleted successfully!');
    }

    public function setDefault(Address $address)
    {
        // Ensure user owns this address
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        // Unset all defaults for this user
        Auth::user()->addresses()->update(['is_default' => false]);

        // Set this address as default
        $address->update(['is_default' => true]);

        return redirect()->route('addresses.index')->with('success', 'Default address updated successfully!');
    }
}

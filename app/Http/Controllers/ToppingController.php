<?php

namespace App\Http\Controllers;

use App\Models\Topping;
use Illuminate\Http\Request;

class ToppingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $toppings = Topping::all()->map(function ($topping) {
            $topping->image_url = $topping->image_url ?? 'https://placehold.co/600x400.png';
            return $topping;
        });
        return view('topping.index', compact('toppings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Topping $topping)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Topping $topping)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Topping $topping)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Topping $topping)
    {
        //
    }
}

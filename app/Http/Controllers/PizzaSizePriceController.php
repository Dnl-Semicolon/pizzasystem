<?php

namespace App\Http\Controllers;

use App\Models\PizzaSizePrice;
use Illuminate\Http\Request;

class PizzaSizePriceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pizzaSizePrices = PizzaSizePrice::with(['pizza.product', 'size'])->get();
        return view('pizza.sizePrices.index', compact('pizzaSizePrices'));
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
    public function show(PizzaSizePrice $pizzaSizePrice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PizzaSizePrice $pizzaSizePrice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PizzaSizePrice $pizzaSizePrice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PizzaSizePrice $pizzaSizePrice)
    {
        //
    }
}

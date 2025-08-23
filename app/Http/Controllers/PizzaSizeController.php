<?php

namespace App\Http\Controllers;

use App\Models\PizzaSize;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PizzaSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $sizes = PizzaSize::all();
        return view('pizza.sizes.index', compact('sizes'));
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
    public function show(PizzaSize $pizzaSize)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PizzaSize $pizzaSize)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PizzaSize $pizzaSize)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PizzaSize $pizzaSize)
    {
        //
    }
}

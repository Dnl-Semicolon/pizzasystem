<?php

namespace App\Http\Controllers;

use App\Models\PizzaOrderItemTopping;
use Illuminate\Http\Request;

class PizzaOrderItemToppingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $toppings = PizzaOrderItemTopping::with([
            'orderItem.order',
            'orderItem.product',
            'topping',
        ])->get();

        return view('order.pizzaItemTopping.index', compact('toppings'));
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
    public function show(PizzaOrderItemTopping $pizzaOrderItemTopping)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PizzaOrderItemTopping $pizzaOrderItemTopping)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PizzaOrderItemTopping $pizzaOrderItemTopping)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PizzaOrderItemTopping $pizzaOrderItemTopping)
    {
        //
    }
}

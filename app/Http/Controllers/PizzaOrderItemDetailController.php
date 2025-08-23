<?php

namespace App\Http\Controllers;

use App\Models\PizzaOrderItemDetail;
use App\Models\PizzaOrderItemTopping;
use Illuminate\Http\Request;

class PizzaOrderItemDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $details = PizzaOrderItemDetail::with([
            'orderItem.order',
            'orderItem.product',
            'size',
            'crust',
        ])->get();

        $toppings = PizzaOrderItemTopping::with([
            'topping',
        ])->get();

        return view('order.pizzaItem.index', compact('details', 'toppings'));
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
    public function show(PizzaOrderItemDetail $pizzaOrderItemDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PizzaOrderItemDetail $pizzaOrderItemDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PizzaOrderItemDetail $pizzaOrderItemDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PizzaOrderItemDetail $pizzaOrderItemDetail)
    {
        //
    }
}

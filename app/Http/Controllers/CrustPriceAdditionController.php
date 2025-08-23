<?php

namespace App\Http\Controllers;

use App\Models\CrustPriceAddition;
use Illuminate\Http\Request;

class CrustPriceAdditionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $crustPriceAdditions = CrustPriceAddition::with(['crust', 'size'])->get();

        return view('pizza.crustPriceAdditions.index', compact('crustPriceAdditions'));
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
    public function show(CrustPriceAddition $crustPriceAddition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CrustPriceAddition $crustPriceAddition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CrustPriceAddition $crustPriceAddition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CrustPriceAddition $crustPriceAddition)
    {
        //
    }
}

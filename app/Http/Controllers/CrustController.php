<?php

namespace App\Http\Controllers;

use App\Models\Crust;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CrustController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $crusts = Crust::all();
        return view('pizza.crusts.index', compact('crusts'));
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
    public function show(Crust $crust)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Crust $crust)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Crust $crust)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Crust $crust)
    {
        //
    }
}

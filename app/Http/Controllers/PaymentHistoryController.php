<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentHistoryController extends Controller
{
    /**
     * Display the payment history.
     */
    public function index(): View
    {
        return view('payment.history');
    }
}

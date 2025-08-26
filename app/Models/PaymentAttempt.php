<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentAttempt extends Model
{
    protected $fillable = [
        'payable_type',
        'payable_id',
        'method',
        'status',
        'amount',
        'idempotency_key',
        'error_code',
        'error_message',
        'raw',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'payable_type',
        'payable_id',
        'currency',
        'amount',
        'method',
        'status',
        'captured_at',
        'reference',
        'meta',
    ];
}

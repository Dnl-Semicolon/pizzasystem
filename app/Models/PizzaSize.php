<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PizzaSize extends Model
{
    /** @use HasFactory<\Database\Factories\PizzaSizeFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
    ];
}

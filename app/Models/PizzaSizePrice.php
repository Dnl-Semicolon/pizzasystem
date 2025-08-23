<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PizzaSizePrice extends Model
{
    /** @use HasFactory<\Database\Factories\PizzaSizePriceFactory> */
    use HasFactory;

    protected $fillable = [
        'pizza_id',
        'pizza_size_id',
        'base_price',
    ];

    public function pizza(): BelongsTo
    {
        return $this->belongsTo(Pizza::class);
    }

    public function size(): BelongsTo
    {
        return $this->belongsTo(PizzaSize::class, 'pizza_size_id');
    }
}

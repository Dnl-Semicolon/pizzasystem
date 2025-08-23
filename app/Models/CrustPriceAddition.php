<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CrustPriceAddition extends Model
{
    /** @use HasFactory<\Database\Factories\CrustPriceAdditionFactory> */
    use HasFactory;

    protected $fillable = [
        'crust_id',
        'pizza_size_id',
        'price_addition',
    ];

    public function crust(): BelongsTo
    {
        return $this->belongsTo(Crust::class);
    }

    public function size(): BelongsTo
    {
        return $this->belongsTo(PizzaSize::class, 'pizza_size_id');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PizzaOrderItemDetail extends Model
{
    /** @use HasFactory<\Database\Factories\PizzaOrderItemDetailFactory> */
    use HasFactory;

    protected $fillable = [
        'order_item_id',
        'pizza_size_id',
        'crust_id',
        'base_price',
        'crust_addition',
        'toppings_total',
    ];

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class, 'order_item_id');
    }

    public function size(): BelongsTo
    {
        return $this->belongsTo(PizzaSize::class, 'pizza_size_id');
    }

    public function crust(): BelongsTo
    {
        return $this->belongsTo(Crust::class);
    }

}

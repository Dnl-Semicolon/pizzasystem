<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PizzaOrderItemTopping extends Model
{
    /** @use HasFactory<\Database\Factories\PizzaOrderItemToppingFactory> */
    use HasFactory;

    protected $fillable = [
        'order_item_id',
        'topping_id',
        'topping_price',
    ];

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class, 'order_item_id');
    }

    public function topping(): BelongsTo
    {
        return $this->belongsTo(Topping::class);
    }

}

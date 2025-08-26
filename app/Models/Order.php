<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static whereDate(string $string, \Illuminate\Support\Carbon $today)
 * @method static selectRaw(string $string)
 */
class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'user_id',
        'total_amount',
        'subtotal_cents',
        'discount_cents',
        'tax_cents',
        'delivery_cents',
        'rounding_cents',
        'grand_total_cents',
        'paid_total_cents',
        'status',
        'paid_at',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function getAmountDueCentsAttribute(): int {
        return max($this->grand_total_cents - $this->paid_total_cents, 0);
    }
    public function getIsPaidAttribute(): bool {
        return $this->getAmountDueCentsAttribute() === 0;
    }
}

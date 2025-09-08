<?php

// app/Models/Order.php - Added customer_name to fillable fields

namespace App\Models;

use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $paid_total_cents
 * @property int $grand_total_cents
 * @method static whereDate(string $string, Carbon $today)
 * @method static selectRaw(string $string)
 */
class Order extends Model
{
    /** @use HasFactory<OrderFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_name',
        'subtotal_cents',
        'discount_cents',
        'tax_cents',
        'delivery_cents',
        'rounding_cents',
        'grand_total_cents',
        'paid_total_cents',
        'status',
        'previous_status',
        'paid_at',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'payable_id')->where('payable_type', 'order');
    }

    public function getAmountDueCentsAttribute(): int {
        return max($this->grand_total_cents - $this->paid_total_cents, 0);
    }
    public function getIsPaidAttribute(): bool {
        return $this->getAmountDueCentsAttribute() === 0;
    }
}

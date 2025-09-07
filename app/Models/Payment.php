<?php

namespace App\Models;

// pizzasystem/app/Models/Payment.php

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $payable_type
 * @property int $payable_id
 * @property string $currency
 * @property int $amount // store cents as int
 * @property string $method
 * @property string $status
 * @property Carbon|null $captured_at
 * @property string|null $reference
 * @property array|null $meta
 */
class Payment extends Model
{
    use HasFactory;

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

    protected $casts = [
        'amount'      => 'integer',
        'captured_at' => 'datetime',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Crypt;

class SavedPaymentMethod extends Model
{
    protected $fillable = [
        'user_id',
        'label',
        'card_number',
        'cardholder_name',
        'card_brand',
        'card_last4',
        'exp_month',
        'exp_year',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'exp_month' => 'integer',
        'exp_year' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function setCardNumberAttribute($value): void
    {
        $cleanNumber = preg_replace('/\D+/', '', $value);
        $this->attributes['encrypted_card_number'] = Crypt::encryptString($cleanNumber);
        $this->attributes['card_last4'] = substr($cleanNumber, -4);
        $this->attributes['card_brand'] = $this->determineBrand($cleanNumber);
    }

    public function getCardNumberAttribute(): string
    {
        return Crypt::decryptString($this->attributes['encrypted_card_number']);
    }

    public function getFormattedCardNumberAttribute(): string
    {
        $number = $this->getCardNumberAttribute();
        return chunk_split($number, 4, ' ');
    }

    public function getMaskedCardNumberAttribute(): string
    {
        return '•••• •••• •••• ' . $this->card_last4;
    }

    public function getExpiryAttribute(): string
    {
        return sprintf('%02d/%02d', $this->exp_month, $this->exp_year % 100);
    }

    public function getDisplayNameAttribute(): string
    {
        $brand = $this->card_brand;
        $last4 = $this->card_last4;
        $label = $this->label ? " ({$this->label})" : '';
        
        return "{$brand} •••• {$last4}{$label}";
    }

    private function determineBrand(string $number): string
    {
        if (preg_match('/^4\d{12,18}$/', $number)) {
            return 'VISA';
        }
        
        if (preg_match('/^5[1-5]\d{14}$/', $number)) {
            return 'MASTERCARD';
        }
        
        if (preg_match('/^3[47]\d{13}$/', $number)) {
            return 'AMEX';
        }
        
        if (preg_match('/^6(?:011|5\d{2})\d{12}$/', $number)) {
            return 'DISCOVER';
        }
        
        return 'CARD';
    }

    public static function createFromPaymentData(int $userId, array $data): self
    {
        return self::create([
            'user_id' => $userId,
            'label' => $data['label'] ?? null,
            'card_number' => $data['card_number'],
            'cardholder_name' => $data['card_name'],
            'exp_month' => (int) substr($data['exp'], 0, 2),
            'exp_year' => 2000 + (int) substr($data['exp'], 3, 2),
        ]);
    }
}
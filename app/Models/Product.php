<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'description',
        'image_url',
        'price',
        'is_active',
    ];

    public function pizza(): HasOne
    {
        return $this->hasOne(Pizza::class);
    }

}

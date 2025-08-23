<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crust extends Model
{
    /** @use HasFactory<\Database\Factories\CrustFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'image_url',
    ];
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('saved_payment_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('label')->nullable(); // "Personal Visa", "Work Card", etc.
            $table->text('encrypted_card_number'); // Full encrypted card number
            $table->string('cardholder_name');
            $table->string('card_brand'); // VISA, MASTERCARD, AMEX
            $table->string('card_last4'); // For display purposes
            $table->integer('exp_month');
            $table->integer('exp_year');
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saved_payment_methods');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment_attempts', function (Blueprint $table) {
            $table->id();
            $table->string('payable_type');
            $table->bigInteger('payable_id');
            $table->string('method');
            $table->enum('status', ['pending', 'requires_action', 'succeeded', 'failed', 'canceled'])->default('pending');
            $table->integer('amount');
            $table->string('idempotency_key')->unique();
            $table->string('error_code')->nullable();
            $table->text('error_message')->nullable();
            $table->json('raw')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_attempts');
    }
};

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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->nullable();
            $table->decimal('total_amount', 8, 2);
            $table->integer('subtotal_cents')->nullable();
            $table->integer('discount_cents')->nullable();
            $table->integer('tax_cents')->nullable();
            $table->integer('delivery_cents')->nullable();
            $table->integer('rounding_cents')->nullable();
            $table->integer('grand_total_cents')->nullable();
            $table->integer('paid_total_cents')->nullable();
            $table->enum('status', ['draft', 'pending_payment', 'paid', 'cancelled'])->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

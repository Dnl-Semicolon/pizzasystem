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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade'); // Foreign key to orders.id, delete orderItem if order is deleted
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // Foreign key to products.id, delete pizza if product is deleted
            $table->integer('quantity');
            $table->decimal('unit_price', 8, 2);
            $table->decimal('final_price', 8, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};

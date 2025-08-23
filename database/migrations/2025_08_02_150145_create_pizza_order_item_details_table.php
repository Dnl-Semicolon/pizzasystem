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
        Schema::create('pizza_order_item_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_item_id')
                ->constrained('order_items')
                ->onDelete('cascade');

            $table->foreignId('pizza_size_id')
                ->constrained('pizza_sizes')
                ->onDelete('cascade');

            $table->foreignId('crust_id')
                ->constrained('crusts')
                ->onDelete('cascade');

            $table->decimal('base_price', 8, 2);

            $table->decimal('crust_addition', 8, 2);

            $table->decimal('toppings_total', 8, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pizza_order_item_details');
    }
};

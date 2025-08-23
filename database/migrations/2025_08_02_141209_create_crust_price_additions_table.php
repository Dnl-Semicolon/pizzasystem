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
        Schema::create('crust_price_additions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('crust_id')->constrained()->onDelete('cascade');
            $table->foreignId('pizza_size_id')->constrained('pizza_sizes')->onDelete('cascade');
            $table->decimal('price_addition', 8, 2)->default(0.00);

            $table->timestamps();

            $table->unique(['crust_id', 'pizza_size_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crust_price_additions');
    }
};

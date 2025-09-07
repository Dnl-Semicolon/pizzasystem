<?php
/**
 * pizzasystem/database/migrations/2025_08_02_150141_create_orders_table.php
 * */
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
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('subtotal_cents');
            $table->integer('discount_cents');
            $table->integer('tax_cents');
            $table->integer('delivery_cents');
            $table->integer('rounding_cents');
            $table->integer('grand_total_cents');
            $table->integer('paid_total_cents');
            $table->enum('status', ['draft', 'pending_payment', 'paid', 'cancelled']);
            $table->enum('previous_status', ['draft', 'pending_payment', 'paid', 'cancelled'])->nullable();
            $table->timestamp('paid_at')->nullable()->default(null);
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

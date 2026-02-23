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
            $table->string('order_number')->unique();

            // customer (no login)
            $table->string('customer_name');
            $table->string('customer_email')->nullable();
            $table->string('customer_phone');
            $table->text('shipping_address');

            // payment method
            $table->enum('payment_method', ['cod', 'online_manual']);

            // admin payment status
            $table->enum('payment_status', ['unpaid', 'pending_verification', 'paid'])->default('unpaid');

            // delivery tracking for admin
            $table->enum('delivery_status', ['pending', 'done'])->default('pending');

            // payment proof in same table (nullable)
            $table->string('payment_proof_path')->nullable();
            $table->string('payment_reference_note')->nullable();

            // totals
            $table->unsignedInteger('subtotal');
            $table->unsignedInteger('discount_total')->default(0);
            $table->unsignedInteger('grand_total');

            $table->timestamps();

            $table->index(['payment_method', 'payment_status', 'delivery_status']);
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

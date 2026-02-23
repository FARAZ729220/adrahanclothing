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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // no foreign key, just store category id
            $table->unsignedBigInteger('category_id')->index();

            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            $table->unsignedInteger('price'); // PKR integer
            $table->unsignedInteger('stock')->default(0);

            // store sizes in JSON array e.g. ["S","M","L","XL"]
            $table->json('sizes')->nullable();

            // multiple images JSON array e.g. ["products/a.jpg","products/b.jpg"]
            $table->json('images')->nullable();

            // discount
            $table->enum('discount_type', ['none', 'fixed', 'percent'])->default('none');
            $table->unsignedInteger('discount_value')->default(0);

            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'stock']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

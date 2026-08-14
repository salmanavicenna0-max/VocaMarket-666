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
            $table->unsignedBigInteger('department_id')->nullable();
            $table->string('type')->nullable();
            $table->string('category')->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('price');
            $table->string('image_path')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('original_price')->nullable();
            $table->integer('discount_percentage')->nullable();
            $table->integer('sales_count')->default(0);
            $table->decimal('rating', 3, 2)->nullable();
            $table->integer('reviews_count')->default(0);
            $table->integer('stock')->default(0);
            $table->string('store_name')->nullable();
            $table->string('store_location')->nullable();
            $table->boolean('is_star')->default(false);
            $table->boolean('is_promo')->default(false);
            $table->timestamps();
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

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
            $table->foreignId('order_id')->constrained('orders')->onDelete('restrict');
            $table->foreignId('product_id')->constrained('products')->onDelete('restrict');
            $table->string('name_snapshot');                                // Ghif: Sebagai nama product, saat beli
            $table->decimal('price_snapshot', 10, 2);       // Ghif: Sebagai harga prodouct, saat beli
            $table->unsignedInteger('quantity')->default(1); // Jumlah product yang dibeli
            $table->decimal('subtotal', 15, 2);
            $table->text('note')->nullable();
            $table->string('file_design')->nullable();
            $table->timestamps();

            $table->index('order_id', 'idx_order_items_order');
            $table->index('product_id', 'idx_order_items_product');
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

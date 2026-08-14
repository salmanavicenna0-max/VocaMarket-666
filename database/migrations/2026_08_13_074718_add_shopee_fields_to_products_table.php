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
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('original_price', 15, 2)->nullable()->after('price');
            $table->integer('discount_percentage')->nullable()->after('original_price');
            $table->integer('sales_count')->default(0)->after('discount_percentage');
            $table->decimal('rating', 3, 1)->default(0)->after('sales_count');
            $table->integer('reviews_count')->default(0)->after('rating');
            $table->integer('stock')->default(0)->after('reviews_count');
            $table->string('store_name')->nullable()->after('stock');
            $table->string('store_location')->nullable()->after('store_name');
            $table->boolean('is_star')->default(false)->after('store_location');
            $table->boolean('is_promo')->default(false)->after('is_star');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'original_price', 'discount_percentage', 'sales_count', 'rating',
                'reviews_count', 'stock', 'store_name', 'store_location', 'is_star', 'is_promo'
            ]);
        });
    }
};

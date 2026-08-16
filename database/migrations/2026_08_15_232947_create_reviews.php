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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('set null');
            $table->unsignedTinyInteger('rating');
            $table->text('comment')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();

            // Ghif: data ga spam, 1 user buat 1 kali produck ae.
            $table->unique(['product_id', 'user_id'], 'unique_reviews_product_user');
            $table->index('user_id', 'idx_reviews_user');
            $table->index('product_id', 'idx_reviews_product');
            $table->index('status', 'idx_reviews_status');

            });
        DB::statement('ALTER TABLE reviews ADD CONSTRAINT check_reviews_rating CHECK (rating BETWEEN 1 and 5)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};

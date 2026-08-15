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
            $table->string('code_order', 30)->unique(); // Kaya: ABC-1234-1234-1234, atau apalah. ESK-20260814-0001
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict');
            $table->enum('status', ['menunggu_pembayaran', 'menunggu_verifikasi', 'diproses', 'selesai', 'dibatalkan', 'ditolak'])->default('menunggu_pembayaran');
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('discount', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);
            $table->text('note')->nullable();
            $table->string('link_wa', 255)->nullable();
            $table->timestamps();

            $table->index('user_id', 'idx_orders_user');
            $table->index('status', 'idx_orders_status');
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

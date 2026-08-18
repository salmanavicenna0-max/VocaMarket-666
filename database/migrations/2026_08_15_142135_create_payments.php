<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    /* Note: Ghif:
        Table paymen ini buat transasksi, jika sudah melakukan order, tinggal tunggu pembayaran ,dan jadilah paymen. jika setuju maka menjadi transaksi
    */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('restrict');
            $table->decimal('amount', 15, 2);
            $table->string('method', 50)->default('transfer');
            $table->string('payment_proof', 255);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('verified_at')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();

            $table->index('order_id', 'idx_payments_order');
            $table->index('status', 'idx_payments_status');
            $table->index('verified_by', 'idx_payments_verified_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

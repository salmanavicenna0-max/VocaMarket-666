<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('products', 'approval_status')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('approval_status')->default('pending')->after('is_active');
            });

            // Set existing active products to approved
            DB::table('products')->where('is_active', true)->update(['approval_status' => 'approved']);
            DB::table('products')->where('is_active', false)->update(['approval_status' => 'pending']);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('products', 'approval_status')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('approval_status');
            });
        }
    }
};

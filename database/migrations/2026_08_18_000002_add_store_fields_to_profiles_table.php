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
        Schema::table('profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('profiles', 'nama_toko')) {
                $table->string('nama_toko')->nullable();
            }
            if (!Schema::hasColumn('profiles', 'deskripsi_toko')) {
                $table->text('deskripsi_toko')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            if (Schema::hasColumn('profiles', 'nama_toko')) {
                $table->dropColumn('nama_toko');
            }
            if (Schema::hasColumn('profiles', 'deskripsi_toko')) {
                $table->dropColumn('deskripsi_toko');
            }
        });
    }
};

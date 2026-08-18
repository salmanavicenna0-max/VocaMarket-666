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
            if (!Schema::hasColumn('profiles', 'no_telp')) {
                $table->string('no_telp')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('profiles', 'photo') && !Schema::hasColumn('profiles', 'foto')) {
                $table->string('photo')->nullable();
            }
            if (!Schema::hasColumn('profiles', 'class') && !Schema::hasColumn('profiles', 'kelas')) {
                $table->string('class')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            if (Schema::hasColumn('profiles', 'no_telp')) {
                $table->dropColumn('no_telp');
            }
        });
    }
};

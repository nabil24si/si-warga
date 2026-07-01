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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('status_akun', ['pending', 'aktif', 'ditolak'])->default('pending')->after('role');
        });

        // Set existing non-warga users to aktif
        \Illuminate\Support\Facades\DB::table('users')
            ->where('role', '!=', 'warga')
            ->update(['status_akun' => 'aktif']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('status_akun');
        });
    }
};

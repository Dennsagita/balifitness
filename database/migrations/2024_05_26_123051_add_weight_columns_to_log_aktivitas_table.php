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
        Schema::table('log_aktivitas', function (Blueprint $table) {
            $table->float('berat_badan_awal')->nullable()->after('deskripsi');
            $table->float('berat_badan_sekarang')->nullable()->after('berat_badan_awal');
            $table->float('target_berat_badan')->nullable()->after('berat_badan_sekarang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('log_aktivitas', function (Blueprint $table) {
            $table->dropColumn(['berat_badan_awal', 'berat_badan_sekarang', 'target_berat_badan']);
        });
    }
};

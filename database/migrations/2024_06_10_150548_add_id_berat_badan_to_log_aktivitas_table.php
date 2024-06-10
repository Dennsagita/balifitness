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
            $table->unsignedBigInteger('id_berat_badan')->nullable()->after('id_members');

            $table->foreign('id_berat_badan')->references('id')->on('berat_badan')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('log_aktivitas', function (Blueprint $table) {
            $table->dropForeign(['id_berat_badan']);
            $table->dropColumn('id_berat_badan');
        });
    }
};

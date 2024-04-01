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
        Schema::table('materis', function (Blueprint $table) {
            $table->unsignedBigInteger('id_coach')->after('id');

            // Menambahkan foreign key constraint
            $table->foreign('id_coach')
                ->references('id')
                ->on('coaches')
                ->onDelete('cascade'); // Jika coach dihapus, materi yang terkait juga dihapus
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materis', function (Blueprint $table) {
            $table->dropForeign(['id_coach']); // Menghapus foreign key constraint
            $table->dropColumn('id_coach'); // Menghapus kolom id_coach
        });
    }
};

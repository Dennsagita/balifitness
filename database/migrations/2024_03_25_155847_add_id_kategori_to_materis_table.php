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
            $table->unsignedBigInteger('id_kategori')->after('id');

            // Menambahkan foreign key constraint
            $table->foreign('id_kategori')
                ->references('id')
                ->on('kategoris')
                ->onDelete('cascade'); // Jika coach dihapus, materi yang terkait juga dihapus
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materis', function (Blueprint $table) {
            // Menghapus foreign key constraint
            $table->dropForeign(['id_kategori']);

            // Menghapus kolom id_kategori
            $table->dropColumn('id_kategori');
        });
    }
};

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
        Schema::create('log_aktivitas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_members');
            $table->unsignedBigInteger('id_materi');
            $table->text('deskripsi');
            $table->timestamps();

            // Menambahkan foreign key constraint
            $table->foreign('id_members')->references('id')->on('members');
            $table->foreign('id_materi')->references('id')->on('materis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_aktivitas');
    }
};

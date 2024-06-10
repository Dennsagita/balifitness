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
        Schema::create('berat_badan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_member');
            $table->string('berat_badan');
            $table->timestamps();
            $table->foreign('id_member')->references('id')->on('members')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berat_badan');
    }
};

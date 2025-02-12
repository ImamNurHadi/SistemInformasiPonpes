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
        Schema::create('master_kompleks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_gedung');
            $table->string('nama_kamar');
            $table->timestamps();
            
            // Membuat kombinasi unik untuk nama_gedung dan nama_kamar
            $table->unique(['nama_gedung', 'nama_kamar']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_kompleks');
    }
}; 
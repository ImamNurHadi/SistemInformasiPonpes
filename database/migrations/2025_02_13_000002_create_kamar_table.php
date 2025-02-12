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
        Schema::create('kamar', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('kompleks_id')->constrained('master_kompleks')->onDelete('cascade');
            $table->string('nama_kamar', 255);
            $table->timestamps();
            
            // Membuat unique constraint untuk kombinasi kompleks_id dan nama_kamar
            $table->unique(['kompleks_id', 'nama_kamar']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kamar');
    }
}; 
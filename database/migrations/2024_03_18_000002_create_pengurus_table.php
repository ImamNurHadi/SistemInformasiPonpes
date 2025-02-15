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
        Schema::create('pengurus', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama');
            $table->string('nik', 20)->unique();
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('telepon', 15);
            $table->string('kelurahan_domisili');
            $table->string('kecamatan_domisili');
            $table->string('kota_domisili');
            $table->string('kelurahan_kk');
            $table->string('kecamatan_kk');
            $table->string('kota_kk');
            $table->string('jabatan');
            $table->string('sub_divisi')->nullable();
            $table->uuid('divisi_id')->nullable();
            $table->timestamps();

            $table->foreign('divisi_id')
                  ->references('id')
                  ->on('divisis')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengurus');
    }
}; 
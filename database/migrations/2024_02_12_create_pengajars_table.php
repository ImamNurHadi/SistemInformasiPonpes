<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajars', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nik')->unique();
            $table->date('tanggal_lahir');
            $table->string('telepon');
            
            // Alamat Domisili
            $table->string('kelurahan_domisili');
            $table->string('kecamatan_domisili');
            $table->string('kota_domisili');
            
            // Alamat KK
            $table->string('kelurahan_kk');
            $table->string('kecamatan_kk');
            $table->string('kota_kk');
            
            // Pendidikan
            $table->enum('pendidikan_terakhir', ['SMA/Sederajat', 'S-1/Sederajat', 'S-2/Sederajat', 'S-3/Sederajat']);
            $table->string('asal_kampus')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajars');
    }
}; 
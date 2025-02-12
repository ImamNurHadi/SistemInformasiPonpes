<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pengurus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('nama');
            $table->string('nik')->unique();
            $table->string('tempat_lahir');
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
            
            // Divisi
            $table->foreignId('divisi_id')->nullable()->constrained()->onDelete('set null');
            $table->string('sub_divisi')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengurus');
    }
}; 
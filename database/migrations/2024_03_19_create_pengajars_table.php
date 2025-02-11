<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pengajars', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nuptk')->unique();
            $table->string('nik')->unique();
            $table->date('tanggal_lahir');
            $table->string('telepon');
            $table->text('alamat');
            $table->string('bidang_mata_pelajaran');
            $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Aktif');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengajars');
    }
}; 
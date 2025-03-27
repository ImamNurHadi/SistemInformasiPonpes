<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('akun_utamas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_akun');
            $table->string('kode_akun')->unique();
            $table->decimal('saldo', 15, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('akun_utamas');
    }
}; 
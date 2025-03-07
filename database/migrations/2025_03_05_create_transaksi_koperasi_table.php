<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transaksi_koperasi', function (Blueprint $table) {
            $table->id();
            $table->uuid('santri_id');
            $table->string('nama_barang');
            $table->decimal('harga_satuan', 10, 2);
            $table->integer('kuantitas');
            $table->decimal('total', 10, 2);
            $table->timestamps();

            $table->foreign('santri_id')
                  ->references('id')
                  ->on('santri')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksi_koperasi');
    }
}; 
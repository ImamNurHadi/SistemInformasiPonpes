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
        Schema::create('pembayaran_santris', function (Blueprint $table) {
            $table->id();
            $table->uuid('santri_id');
            $table->string('jenis_pembayaran'); // pondok, kamar, ruang_kelas, tingkatan, komplek
            $table->string('keterangan')->nullable();
            $table->decimal('jumlah', 12, 2);
            $table->timestamps();

            $table->foreign('santri_id')->references('id')->on('santri')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_santris');
    }
};

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
        Schema::create('santri', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('nis')->unique();
            $table->string('nama');
            $table->string('tempat_lahir', 255);
            $table->date('tanggal_lahir');
            $table->integer('anak_ke');
            $table->integer('jumlah_saudara_kandung');
            $table->string('kelurahan', 255);
            $table->string('kecamatan', 255);
            $table->string('kabupaten_kota', 255);
            $table->string('nomor_induk_santri', 50)->unique();
            $table->string('asrama');
            $table->string('kamar');
            $table->foreignUuid('tingkatan_masuk')->constrained('master_tingkatan');
            $table->foreignUuid('tingkatan_id')->constrained('master_tingkatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('santri');
    }
};

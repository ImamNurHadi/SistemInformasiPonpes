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
        Schema::create('wali_santri', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('santri_id')->constrained('santri')->onDelete('cascade');
            $table->string('nama_wali', 255);
            $table->foreignUuid('kelas')->nullable()->constrained('master_tingkatan')->onDelete('set null');
            $table->string('asal_kota', 255);
            $table->string('nama_ayah', 255);
            $table->text('alamat_kk_ayah');
            $table->text('alamat_domisili_ayah');
            $table->string('no_identitas_ayah', 50)->unique()->nullable();
            $table->string('no_hp_ayah', 20)->nullable();
            $table->string('pendidikan_ayah', 255);
            $table->string('pekerjaan_ayah', 255);
            $table->string('nama_ibu', 255);
            $table->text('alamat_kk_ibu');
            $table->text('alamat_domisili_ibu');
            $table->string('no_identitas_ibu', 50)->unique()->nullable();
            $table->string('no_hp_ibu', 20)->nullable();
            $table->string('pendidikan_ibu', 255);
            $table->string('pekerjaan_ibu', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wali_santri');
    }
};

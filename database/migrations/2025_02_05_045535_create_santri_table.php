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
            $table->string('nis')->unique();
            $table->string('nama');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('alamat');
            $table->string('nama_ayah');
            $table->string('nama_ibu');
            $table->string('no_hp');
            $table->string('foto')->nullable();
            $table->foreignUuid('tingkatan_masuk')->constrained('master_tingkatan');
            $table->uuid('tingkatan_id')->nullable();
            $table->uuid('gedung_id')->nullable();
            $table->uuid('kamar_id')->nullable();
            $table->decimal('saldo_utama', 10, 2)->default(0);
            $table->decimal('saldo_belanja', 10, 2)->default(0);
            $table->decimal('saldo_tabungan', 10, 2)->default(0);
            $table->timestamps();

            $table->foreign('tingkatan_id')
                  ->references('id')
                  ->on('master_tingkatan')
                  ->onDelete('set null');
            
            $table->foreign('gedung_id')
                  ->references('id')
                  ->on('gedung')
                  ->onDelete('set null');

            $table->foreign('kamar_id')
                  ->references('id')
                  ->on('kamar')
                  ->onDelete('set null');
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

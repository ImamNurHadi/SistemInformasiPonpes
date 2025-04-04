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
        Schema::create('histori_transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('santri_pengirim_id')->constrained('santri')->onDelete('cascade');
            $table->foreignUuid('santri_penerima_id')->constrained('santri')->onDelete('cascade');
            $table->decimal('jumlah', 12, 2);
            $table->enum('tipe_sumber', ['utama', 'belanja', 'tabungan']);
            $table->enum('tipe_tujuan', ['utama', 'belanja', 'tabungan']);
            $table->text('keterangan')->nullable();
            $table->timestamp('tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histori_transfers');
    }
};

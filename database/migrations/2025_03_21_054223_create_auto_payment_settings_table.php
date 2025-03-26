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
        Schema::create('auto_payment_settings', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_pembayaran'); // pondok, kamar, ruang_kelas, tingkatan, komplek
            $table->decimal('jumlah', 12, 2);
            $table->integer('tanggal_eksekusi')->default(1); // Day of month for execution (1-28)
            $table->boolean('aktif')->default(true); // Status active/inactive
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auto_payment_settings');
    }
};

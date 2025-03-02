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
        Schema::table('histori_saldo', function (Blueprint $table) {
            // Tambahkan kolom jenis_saldo jika belum ada
            if (!Schema::hasColumn('histori_saldo', 'jenis_saldo')) {
                $table->string('jenis_saldo')->nullable()->after('tipe')->comment('utama, belanja, atau tabungan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('histori_saldo', function (Blueprint $table) {
            // Hapus kolom jika ada
            if (Schema::hasColumn('histori_saldo', 'jenis_saldo')) {
                $table->dropColumn('jenis_saldo');
            }
        });
    }
};

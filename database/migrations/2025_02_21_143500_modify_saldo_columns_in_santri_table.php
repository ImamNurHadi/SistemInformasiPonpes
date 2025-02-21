<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('santri', function (Blueprint $table) {
            // Drop kolom saldo lama jika ada
            $table->dropColumn('saldo');
            
            // Tambah kolom saldo baru
            $table->decimal('saldo_utama', 10, 2)->default(0);
            $table->decimal('saldo_belanja', 10, 2)->default(0);
            $table->decimal('saldo_tabungan', 10, 2)->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('santri', function (Blueprint $table) {
            // Kembalikan ke struktur awal
            $table->decimal('saldo', 10, 2)->default(0);
            
            $table->dropColumn([
                'saldo_utama',
                'saldo_belanja',
                'saldo_tabungan'
            ]);
        });
    }
}; 
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('santri', function (Blueprint $table) {
            if (!Schema::hasColumn('santri', 'saldo_utama')) {
                $table->decimal('saldo_utama', 10, 2)->default(0);
            }
            if (!Schema::hasColumn('santri', 'saldo_belanja')) {
                $table->decimal('saldo_belanja', 10, 2)->default(0);
            }
            if (!Schema::hasColumn('santri', 'saldo_tabungan')) {
                $table->decimal('saldo_tabungan', 10, 2)->default(0);
            }
        });
    }

    public function down(): void
    {
        Schema::table('santri', function (Blueprint $table) {
            $table->dropColumn([
                'saldo_utama',
                'saldo_belanja',
                'saldo_tabungan'
            ]);
        });
    }
}; 
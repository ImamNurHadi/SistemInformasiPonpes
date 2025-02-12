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
        // Hapus foreign key terlebih dahulu
        Schema::table('santri', function (Blueprint $table) {
            $table->dropForeign(['kamar_id']);
            $table->dropColumn('kamar_id');
        });

        Schema::dropIfExists('kamar');
        Schema::dropIfExists('master_kompleks');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tidak perlu membuat ulang tabel karena akan dibuat di migrasi baru
    }
}; 
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
        Schema::table('santri', function (Blueprint $table) {
            // Tambah kolom kompleks_id
            $table->foreignUuid('kompleks_id')->nullable()->constrained('master_kompleks')->onDelete('set null');
            
            // Hapus kolom asrama karena sudah tidak digunakan
            $table->dropColumn('asrama');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('santri', function (Blueprint $table) {
            // Hapus foreign key dan kolom kompleks_id
            $table->dropForeign(['kompleks_id']);
            $table->dropColumn('kompleks_id');
            
            // Kembalikan kolom asrama
            $table->string('asrama');
        });
    }
}; 
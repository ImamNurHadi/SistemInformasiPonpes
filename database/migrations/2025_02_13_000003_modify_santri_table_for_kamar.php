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
            // Hapus kolom kamar yang lama
            $table->dropColumn('kamar');
            
            // Tambah kolom kamar_id yang baru sebagai foreign key
            $table->foreignUuid('kamar_id')->nullable()->constrained('kamar')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('santri', function (Blueprint $table) {
            // Hapus foreign key dan kolom kamar_id
            $table->dropForeign(['kamar_id']);
            $table->dropColumn('kamar_id');
            
            // Kembalikan kolom kamar yang lama
            $table->string('kamar');
        });
    }
}; 
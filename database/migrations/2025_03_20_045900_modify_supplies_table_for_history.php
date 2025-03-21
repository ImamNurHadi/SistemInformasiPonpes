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
        // Hapus kolom yang tidak diperlukan
        Schema::table('supplies', function (Blueprint $table) {
            $table->dropColumn(['harga_beli', 'harga_jual', 'deskripsi']);
        });
        
        // Tambahkan kolom baru untuk history
        Schema::table('supplies', function (Blueprint $table) {
            $table->unsignedBigInteger('data_koperasi_id')->nullable()->after('supplier_id');
            $table->timestamp('tanggal_masuk')->nullable()->after('data_koperasi_id');
            
            // Tambahkan foreign key ke tabel data_koperasis
            $table->foreign('data_koperasi_id')
                  ->references('id')
                  ->on('data_koperasis')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan struktur tabel seperti semula
        Schema::table('supplies', function (Blueprint $table) {
            // Hapus foreign key dan kolom yang ditambahkan
            $table->dropForeign(['data_koperasi_id']);
            $table->dropColumn(['data_koperasi_id', 'tanggal_masuk']);
        });
        
        // Tambahkan kembali kolom yang dihapus
        Schema::table('supplies', function (Blueprint $table) {
            $table->decimal('harga_beli', 12, 2)->default(0);
            $table->decimal('harga_jual', 12, 2)->default(0);
            $table->text('deskripsi')->nullable();
        });
    }
};

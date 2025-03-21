<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tambahkan kolom kategori_new terlebih dahulu
        Schema::table('supplies', function (Blueprint $table) {
            $table->string('kategori_new')->nullable()->after('kategori');
        });
        
        // Salin data dari kategori ke kategori_new
        DB::statement('UPDATE supplies SET kategori_new = kategori');
        
        // Hapus kolom kategori lama
        Schema::table('supplies', function (Blueprint $table) {
            $table->dropColumn('kategori');
        });
        
        // Rename kategori_new menjadi kategori
        Schema::table('supplies', function (Blueprint $table) {
            $table->renameColumn('kategori_new', 'kategori');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tidak perlu melakukan rollback karena kita hanya ingin memperbaiki kolom yang error
    }
};

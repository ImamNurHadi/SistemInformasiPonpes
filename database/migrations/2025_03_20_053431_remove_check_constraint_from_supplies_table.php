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
        // Hapus check constraint pada kolom kategori
        DB::statement('ALTER TABLE supplies DROP CONSTRAINT IF EXISTS supplies_kategori_check');
        
        // Pastikan kolom kategori dapat menerima nilai null atau string
        DB::statement('ALTER TABLE supplies ALTER COLUMN kategori TYPE VARCHAR(255)');
        DB::statement('ALTER TABLE supplies ALTER COLUMN kategori DROP NOT NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tidak perlu mengembalikan constraint, karena kita tidak tahu constraint aslinya
    }
};

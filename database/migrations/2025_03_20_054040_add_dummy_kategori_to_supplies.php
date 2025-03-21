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
        // Gunakan raw SQL untuk mengatasi masalah constraint
        DB::statement('ALTER TABLE supplies ALTER COLUMN kategori TYPE VARCHAR(255)');
        DB::statement('ALTER TABLE supplies ALTER COLUMN kategori SET DEFAULT \'Umum\'');
        DB::statement('UPDATE supplies SET kategori = \'Umum\' WHERE kategori IS NULL OR kategori = \'\'');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tidak perlu dibalik
    }
};

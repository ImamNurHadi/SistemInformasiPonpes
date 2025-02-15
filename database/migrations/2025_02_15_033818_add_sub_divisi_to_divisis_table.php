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
        Schema::table('divisis', function (Blueprint $table) {
            $table->string('sub_divisi')->nullable()->after('nama');
            $table->text('deskripsi')->nullable()->after('sub_divisi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('divisis', function (Blueprint $table) {
            $table->dropColumn(['sub_divisi', 'deskripsi']);
        });
    }
};

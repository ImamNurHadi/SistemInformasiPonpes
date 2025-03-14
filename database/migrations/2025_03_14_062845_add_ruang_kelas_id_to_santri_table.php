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
            $table->uuid('ruang_kelas_id')->nullable()->after('kamar_id');
            $table->foreign('ruang_kelas_id')->references('id')->on('ruang_kelas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('santri', function (Blueprint $table) {
            $table->dropForeign(['ruang_kelas_id']);
            $table->dropColumn('ruang_kelas_id');
        });
    }
};

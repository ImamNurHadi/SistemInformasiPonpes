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
            $table->integer('anak_ke')->after('no_hp');
            $table->integer('jumlah_saudara_kandung')->after('anak_ke');
            $table->string('kelurahan')->after('jumlah_saudara_kandung');
            $table->string('kecamatan')->after('kelurahan');
            $table->string('kabupaten_kota')->after('kecamatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('santri', function (Blueprint $table) {
            $table->dropColumn([
                'anak_ke',
                'jumlah_saudara_kandung',
                'kelurahan',
                'kecamatan',
                'kabupaten_kota'
            ]);
        });
    }
};

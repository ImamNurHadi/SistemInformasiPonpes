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
        Schema::table('pengurus', function (Blueprint $table) {
            $table->string('nik')->unique()->after('nama');
            $table->string('tempat_lahir')->after('nik');
            $table->date('tanggal_lahir')->after('tempat_lahir');
            $table->string('telepon')->after('tanggal_lahir');
            
            // Alamat Domisili
            $table->string('kelurahan_domisili')->after('telepon');
            $table->string('kecamatan_domisili')->after('kelurahan_domisili');
            $table->string('kota_domisili')->after('kecamatan_domisili');
            
            // Alamat KK
            $table->string('kelurahan_kk')->after('kota_domisili');
            $table->string('kecamatan_kk')->after('kelurahan_kk');
            $table->string('kota_kk')->after('kecamatan_kk');
            
            // Ubah kolom divisi menjadi divisi_id
            $table->dropColumn('divisi');
            $table->foreignId('divisi_id')->nullable()->after('kota_kk')->constrained()->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengurus', function (Blueprint $table) {
            $table->dropForeign(['divisi_id']);
            $table->dropColumn([
                'nik',
                'tempat_lahir',
                'tanggal_lahir',
                'telepon',
                'kelurahan_domisili',
                'kecamatan_domisili',
                'kota_domisili',
                'kelurahan_kk',
                'kecamatan_kk',
                'kota_kk',
                'divisi_id'
            ]);
            $table->string('divisi')->after('nama');
        });
    }
};

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
        // Rename table gedung to komplek
        Schema::rename('gedung', 'komplek');
        
        // Update column nama_gedung to nama_komplek in komplek table
        Schema::table('komplek', function (Blueprint $table) {
            $table->renameColumn('nama_gedung', 'nama_komplek');
        });
        
        // Update foreign key in kamar table
        Schema::table('kamar', function (Blueprint $table) {
            $table->renameColumn('gedung_id', 'komplek_id');
        });
        
        // Update foreign key in santri table
        Schema::table('santri', function (Blueprint $table) {
            $table->renameColumn('gedung_id', 'komplek_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rename table komplek back to gedung
        Schema::rename('komplek', 'gedung');
        
        // Update column nama_komplek back to nama_gedung in gedung table
        Schema::table('gedung', function (Blueprint $table) {
            $table->renameColumn('nama_komplek', 'nama_gedung');
        });
        
        // Update foreign key in kamar table
        Schema::table('kamar', function (Blueprint $table) {
            $table->renameColumn('komplek_id', 'gedung_id');
        });
        
        // Update foreign key in santri table
        Schema::table('santri', function (Blueprint $table) {
            $table->renameColumn('komplek_id', 'gedung_id');
        });
    }
};

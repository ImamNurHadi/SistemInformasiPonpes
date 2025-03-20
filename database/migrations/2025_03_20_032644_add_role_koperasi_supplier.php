<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tambahkan role Koperasi
        DB::table('roles')->insert([
            'id' => Str::uuid()->toString(),
            'name' => 'Koperasi',
            'description' => 'Memiliki akses ke fitur koperasi',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Tambahkan role Supplier
        DB::table('roles')->insert([
            'id' => Str::uuid()->toString(),
            'name' => 'Supplier',
            'description' => 'Memiliki akses ke fitur supplier',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus role Koperasi dan Supplier
        DB::table('roles')->whereIn('name', ['Koperasi', 'Supplier'])->delete();
    }
};

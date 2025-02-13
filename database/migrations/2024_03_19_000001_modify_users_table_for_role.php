<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus kolom role yang lama
            $table->dropColumn('role');
            
            // Tambah kolom role_id yang baru
            $table->foreignUuid('role_id')->nullable()->constrained('roles')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus foreign key dan kolom role_id
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
            
            // Kembalikan kolom role yang lama
            $table->string('role')->default('user');
        });
    }
}; 
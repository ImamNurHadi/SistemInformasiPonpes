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
        Schema::table('data_koperasis', function (Blueprint $table) {
            $table->string('username')->unique()->nullable();
            $table->string('password_hash')->nullable();
            $table->decimal('saldo_belanja', 15, 2)->default(0);
            $table->unsignedBigInteger('user_id')->nullable();
            
            // Tambahkan foreign key ke tabel users
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_koperasis', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['username', 'password_hash', 'saldo_belanja', 'user_id']);
        });
    }
};

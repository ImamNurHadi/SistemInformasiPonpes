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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_supplier');
            $table->string('alamat')->nullable();
            $table->string('telepon', 15)->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('username')->unique();
            $table->string('password_hash');
            $table->decimal('saldo_belanja', 15, 2)->default(0);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
            
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
        Schema::dropIfExists('suppliers');
    }
};

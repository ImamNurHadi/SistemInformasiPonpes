<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('outlet_id')->constrained('users')->onDelete('cascade');
            $table->string('nama');
            $table->decimal('harga', 10, 2);
            $table->string('foto')->nullable();
            $table->integer('stok')->default(0);
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu');
    }
}; 
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('data_koperasis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_koperasi');
            $table->string('lokasi');
            $table->uuid('pengurus_id');
            $table->foreign('pengurus_id')->references('id')->on('pengurus')->onDelete('cascade');
            $table->string('username')->unique();
            $table->string('password_hash');
            $table->decimal('saldo_belanja', 12, 2)->default(0);
            $table->decimal('keuntungan', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('data_koperasis');
    }
}; 
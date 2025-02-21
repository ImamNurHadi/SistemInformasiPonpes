<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('histori_saldo', function (Blueprint $table) {
            $table->enum('jenis_saldo', ['utama', 'belanja', 'tabungan'])->after('tipe')->default('utama');
        });
    }

    public function down()
    {
        Schema::table('histori_saldo', function (Blueprint $table) {
            $table->dropColumn('jenis_saldo');
        });
    }
}; 
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
        Schema::create('histori_saldo', function (Blueprint $table) {
            $table->id();
            $table->uuid('santri_id');
            $table->decimal('jumlah', 10, 2);
            $table->string('keterangan')->nullable();
            $table->string('tipe')->default('masuk'); // masuk/keluar
            $table->timestamps();

            $table->foreign('santri_id')
                  ->references('id')
                  ->on('santri')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histori_saldo');
    }
};

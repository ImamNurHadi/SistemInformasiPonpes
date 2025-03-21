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
        Schema::create('transaksi_suppliers', function (Blueprint $table) {
            $table->id();
            $table->uuid('supplier_id');
            $table->unsignedBigInteger('koperasi_id');
            $table->string('nama_barang');
            $table->decimal('jumlah', 15, 2);
            $table->decimal('harga_satuan', 15, 2);
            $table->decimal('total_harga', 15, 2);
            $table->text('keterangan')->nullable();
            $table->enum('status', ['pending', 'selesai', 'batal'])->default('pending');
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('supplier_id')
                  ->references('id')
                  ->on('suppliers')
                  ->onDelete('cascade');
                  
            $table->foreign('koperasi_id')
                  ->references('id')
                  ->on('data_koperasis')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_suppliers');
    }
};

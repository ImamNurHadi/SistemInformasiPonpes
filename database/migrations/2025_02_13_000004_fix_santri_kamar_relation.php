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
        // Pastikan kolom kamar_id belum ada sebelum menambahkannya
        if (!Schema::hasColumn('santri', 'kamar_id')) {
            Schema::table('santri', function (Blueprint $table) {
                // Tambah kolom kamar_id yang baru sebagai foreign key
                $table->foreignUuid('kamar_id')->nullable()->constrained('kamar')->onDelete('set null');
            });
        }

        // Jika kolom kamar masih ada, hapus
        if (Schema::hasColumn('santri', 'kamar')) {
            Schema::table('santri', function (Blueprint $table) {
                $table->dropColumn('kamar');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('santri', function (Blueprint $table) {
            // Tambah kembali kolom kamar jika belum ada
            if (!Schema::hasColumn('santri', 'kamar')) {
                $table->string('kamar')->nullable();
            }

            // Hapus foreign key dan kolom kamar_id
            if (Schema::hasColumn('santri', 'kamar_id')) {
                $table->dropForeign(['kamar_id']);
                $table->dropColumn('kamar_id');
            }
        });
    }
}; 
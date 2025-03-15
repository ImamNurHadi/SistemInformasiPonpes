<?php

namespace Database\Seeders;

use App\Models\DataKoperasi;
use App\Models\Pengurus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataKoperasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dapatkan ID pengurus yang sudah ada
        $pengurusIds = Pengurus::pluck('id')->toArray();
        
        // Pastikan ada pengurus
        if (empty($pengurusIds)) {
            return; // Jika tidak ada pengurus, tidak perlu membuat data koperasi
        }
        
        // Data koperasi
        $dataKoperasi = [
            [
                'nama_koperasi' => 'Koperasi Putra',
                'lokasi' => 'Gedung A, Lantai 1',
                'pengurus_id' => $pengurusIds[0], // Ahmad Fauzi
            ],
            [
                'nama_koperasi' => 'Koperasi Putri',
                'lokasi' => 'Gedung B, Lantai 1',
                'pengurus_id' => $pengurusIds[1], // Siti Aminah
            ],
            [
                'nama_koperasi' => 'Koperasi Umum',
                'lokasi' => 'Gedung Utama, Lantai 2',
                'pengurus_id' => $pengurusIds[2], // Muhammad Rizki
            ],
        ];
        
        // Masukkan data koperasi
        foreach ($dataKoperasi as $data) {
            DataKoperasi::create($data);
        }
    }
}

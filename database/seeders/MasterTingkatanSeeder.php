<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterTingkatan;

class MasterTingkatanSeeder extends Seeder
{
    public function run(): void
    {
        $tingkatan = MasterTingkatan::create([
            'nama' => 'Kelas 1',
            'keterangan' => 'Tingkatan pertama'
        ]);
    }
} 
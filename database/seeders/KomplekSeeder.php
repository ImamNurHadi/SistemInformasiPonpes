<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Komplek;

class KomplekSeeder extends Seeder
{
    public function run(): void
    {
        Komplek::create([
            'nama_komplek' => 'Komplek A',
            'keterangan' => 'Komplek untuk santri putra tingkat dasar'
        ]);

        Komplek::create([
            'nama_komplek' => 'Komplek B',
            'keterangan' => 'Komplek untuk santri putra tingkat menengah'
        ]);

        Komplek::create([
            'nama_komplek' => 'Komplek C',
            'keterangan' => 'Komplek untuk santri putra tingkat atas'
        ]);
    }
} 
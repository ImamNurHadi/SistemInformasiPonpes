<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kamar;
use App\Models\Komplek;

class KamarSeeder extends Seeder
{
    public function run(): void
    {
        $kompleks = Komplek::all();

        foreach ($kompleks as $komplek) {
            for ($i = 1; $i <= 5; $i++) {
                Kamar::create([
                    'nama_kamar' => "Kamar {$i}",
                    'keterangan' => "Kamar {$i} di {$komplek->nama_komplek}",
                    'komplek_id' => $komplek->id
                ]);
            }
        }
    }
} 
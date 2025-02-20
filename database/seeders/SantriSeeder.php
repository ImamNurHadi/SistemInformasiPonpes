<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Santri;
use App\Models\User;
use App\Models\Role;
use App\Models\MasterTingkatan;
use App\Models\Gedung;
use App\Models\Kamar;
use Illuminate\Support\Facades\Hash;

class SantriSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan role Santri sudah ada
        $santriRole = Role::firstOrCreate(
            ['name' => 'Santri'],
            ['description' => 'Role untuk santri']
        );

        // Buat tingkatan jika belum ada
        $tingkatan = MasterTingkatan::firstOrCreate(
            ['nama' => 'Kelas 7'],
            ['keterangan' => 'Tingkat SMP Kelas 7']
        );

        // Buat gedung jika belum ada
        $gedung = Gedung::firstOrCreate(
            ['nama_gedung' => 'Gedung A'],
            ['keterangan' => 'Gedung Putra']
        );

        // Buat kamar jika belum ada
        $kamar = Kamar::firstOrCreate(
            [
                'nama_kamar' => 'Kamar A1',
                'gedung_id' => $gedung->id
            ],
            ['keterangan' => 'Kamar Lantai 1']
        );

        // Buat user untuk santri
        $user = User::create([
            'name' => 'Mikael',
            'email' => 'mikael@santri.com',
            'password' => Hash::make('santri123'),
            'role_id' => $santriRole->id
        ]);

        // Buat data santri
        $santri = Santri::create([
            'nama' => 'Mikael',
            'nis' => '2024001',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '2010-05-15',
            'jenis_kelamin' => 'L',
            'alamat' => 'Jl. Raya Bogor No. 123',
            'no_hp' => '081234567890',
            'nama_ayah' => 'John Doe',
            'nama_ibu' => 'Jane Doe',
            'anak_ke' => 1,
            'jumlah_saudara_kandung' => 2,
            'kelurahan' => 'Pasar Minggu',
            'kecamatan' => 'Pasar Minggu',
            'kabupaten_kota' => 'Jakarta Selatan',
            'tingkatan_id' => $tingkatan->id,
            'tingkatan_masuk' => $tingkatan->id,
            'gedung_id' => $gedung->id,
            'kamar_id' => $kamar->id,
            'user_id' => $user->id
        ]);

        // Buat data wali santri
        $santri->waliSantri()->create([
            'nama_wali' => 'John Doe',
            'asal_kota' => 'Jakarta',
            'nama_ayah' => 'John Doe',
            'alamat_kk_ayah' => 'Jl. Raya Bogor No. 123',
            'alamat_domisili_ayah' => 'Jl. Raya Bogor No. 123',
            'no_identitas_ayah' => '3171234567890001',
            'no_hp_ayah' => '081234567890',
            'pendidikan_ayah' => 'S1',
            'pekerjaan_ayah' => 'Wiraswasta',
            'nama_ibu' => 'Jane Doe',
            'alamat_kk_ibu' => 'Jl. Raya Bogor No. 123',
            'alamat_domisili_ibu' => 'Jl. Raya Bogor No. 123',
            'no_identitas_ibu' => '3171234567890002',
            'no_hp_ibu' => '081234567891',
            'pendidikan_ibu' => 'S1',
            'pekerjaan_ibu' => 'Ibu Rumah Tangga'
        ]);
    }
} 
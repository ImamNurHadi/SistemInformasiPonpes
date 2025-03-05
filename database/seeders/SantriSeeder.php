<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Santri;
use App\Models\User;
use App\Models\Role;
use App\Models\MasterTingkatan;
use App\Models\Komplek;
use App\Models\Kamar;
use Illuminate\Support\Facades\Hash;

class SantriSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil role santri yang sudah ada
        $roleSantri = Role::where('name', 'Santri')->first();

        if (!$roleSantri) {
            throw new \Exception('Role Santri tidak ditemukan. Pastikan RoleSeeder sudah dijalankan.');
        }

        // Buat user untuk santri
        $user = User::create([
            'name' => 'Santri Demo',
            'email' => 'santri@demo.com',
            'password' => bcrypt('password'),
            'role_id' => $roleSantri->id
        ]);

        // Ambil tingkatan pertama
        $tingkatan = MasterTingkatan::first();

        // Buat data santri
        Santri::create([
            'user_id' => $user->id,
            'nama' => $user->name,
            'nis' => '2024001',
            'tingkatan_id' => $tingkatan->id,
            'komplek_id' => null,
            'kamar_id' => null,
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '2000-01-01',
            'jenis_kelamin' => 'L',
            'alamat' => 'Jl. Demo No. 123',
            'no_hp' => '08123456789',
            'saldo_utama' => 1000000,
            'saldo_belanja' => 500000,
            'saldo_tabungan' => 250000,
            'kelurahan' => 'Demo',
            'kecamatan' => 'Demo',
            'kabupaten_kota' => 'Demo',
            'nama_ayah' => 'Ayah Demo',
            'nama_ibu' => 'Ibu Demo',
            'tingkatan_masuk' => $tingkatan->id,
            'anak_ke' => 1,
            'jumlah_saudara_kandung' => 2
        ]);
    }
} 
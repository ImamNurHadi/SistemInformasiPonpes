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

        // Ambil tingkatan pertama
        $tingkatan = MasterTingkatan::first();
        if (!$tingkatan) {
            throw new \Exception('Tingkatan tidak ditemukan. Pastikan MasterTingkatanSeeder sudah dijalankan.');
        }

        // Ambil komplek dan kamar pertama
        $komplek = Komplek::first();
        $kamar = Kamar::first();

        if (!$komplek || !$kamar) {
            throw new \Exception('Komplek atau Kamar tidak ditemukan. Pastikan data sudah tersedia.');
        }

        // Data santri demo
        $santriData = [
            [
                'nama' => 'Ahmad Fauzi',
                'nis' => '2024001',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '2005-05-15',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Mawar No. 123, RT 02/RW 03',
                'no_hp' => '081234567890',
                'anak_ke' => 2,
                'jumlah_saudara_kandung' => 3,
                'kelurahan' => 'Kebonsari',
                'kecamatan' => 'Jambangan',
                'kabupaten_kota' => 'Surabaya',
                'wali' => [
                    'nama_wali' => 'Abdul Hamid',
                    'asal_kota' => 'Surabaya',
                    'nama_ayah' => 'Abdul Hamid',
                    'alamat_kk_ayah' => 'Jl. Mawar No. 123, RT 02/RW 03, Kebonsari, Jambangan, Surabaya',
                    'alamat_domisili_ayah' => 'Jl. Mawar No. 123, RT 02/RW 03, Kebonsari, Jambangan, Surabaya',
                    'no_identitas_ayah' => '3578101234567890',
                    'no_hp_ayah' => '081234567890',
                    'pendidikan_ayah' => 'S1',
                    'pekerjaan_ayah' => 'Wiraswasta',
                    'nama_ibu' => 'Siti Aminah',
                    'alamat_kk_ibu' => 'Jl. Mawar No. 123, RT 02/RW 03, Kebonsari, Jambangan, Surabaya',
                    'alamat_domisili_ibu' => 'Jl. Mawar No. 123, RT 02/RW 03, Kebonsari, Jambangan, Surabaya',
                    'no_identitas_ibu' => '3578101234567891',
                    'no_hp_ibu' => '081234567891',
                    'pendidikan_ibu' => 'D3',
                    'pekerjaan_ibu' => 'Ibu Rumah Tangga'
                ]
            ],
            [
                'nama' => 'Muhammad Rizki',
                'nis' => '2024002',
                'tempat_lahir' => 'Malang',
                'tanggal_lahir' => '2006-08-20',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Melati No. 45, RT 05/RW 02',
                'no_hp' => '081234567892',
                'anak_ke' => 1,
                'jumlah_saudara_kandung' => 2,
                'kelurahan' => 'Lowokwaru',
                'kecamatan' => 'Lowokwaru',
                'kabupaten_kota' => 'Malang',
                'wali' => [
                    'nama_wali' => 'Ahmad Syafii',
                    'asal_kota' => 'Malang',
                    'nama_ayah' => 'Ahmad Syafii',
                    'alamat_kk_ayah' => 'Jl. Melati No. 45, RT 05/RW 02, Lowokwaru, Malang',
                    'alamat_domisili_ayah' => 'Jl. Melati No. 45, RT 05/RW 02, Lowokwaru, Malang',
                    'no_identitas_ayah' => '3573101234567890',
                    'no_hp_ayah' => '081234567893',
                    'pendidikan_ayah' => 'S2',
                    'pekerjaan_ayah' => 'Dosen',
                    'nama_ibu' => 'Fatimah',
                    'alamat_kk_ibu' => 'Jl. Melati No. 45, RT 05/RW 02, Lowokwaru, Malang',
                    'alamat_domisili_ibu' => 'Jl. Melati No. 45, RT 05/RW 02, Lowokwaru, Malang',
                    'no_identitas_ibu' => '3573101234567891',
                    'no_hp_ibu' => '081234567894',
                    'pendidikan_ibu' => 'S1',
                    'pekerjaan_ibu' => 'Guru'
                ]
            ]
        ];

        foreach ($santriData as $data) {
            // Buat user untuk santri
            $user = User::create([
                'name' => $data['nama'],
                'email' => $data['nis'] . '@santri.ponpes.id',
                'password' => bcrypt($data['nis']),
                'role_id' => $roleSantri->id
            ]);

            // Buat data santri
            $santri = Santri::create([
                'user_id' => $user->id,
                'nama' => $data['nama'],
                'nis' => $data['nis'],
                'tempat_lahir' => $data['tempat_lahir'],
                'tanggal_lahir' => $data['tanggal_lahir'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'alamat' => $data['alamat'],
                'no_hp' => $data['no_hp'],
                'anak_ke' => $data['anak_ke'],
                'jumlah_saudara_kandung' => $data['jumlah_saudara_kandung'],
                'kelurahan' => $data['kelurahan'],
                'kecamatan' => $data['kecamatan'],
                'kabupaten_kota' => $data['kabupaten_kota'],
                'tingkatan_id' => $tingkatan->id,
                'tingkatan_masuk' => $tingkatan->id,
                'komplek_id' => $komplek->id,
                'kamar_id' => $kamar->id,
                'saldo_utama' => 1000000,
                'saldo_belanja' => 500000,
                'saldo_tabungan' => 250000,
                'nama_ayah' => $data['wali']['nama_ayah'],
                'nama_ibu' => $data['wali']['nama_ibu']
            ]);

            // Generate QR Code
            $santri->generateQrCode();

            // Buat data wali santri
            $santri->waliSantri()->create($data['wali']);
        }
    }
} 
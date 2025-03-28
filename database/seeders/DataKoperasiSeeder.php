<?php

namespace Database\Seeders;

use App\Models\DataKoperasi;
use App\Models\Pengurus;
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

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
            $this->command->error('Tidak ada pengurus yang tersedia. Silakan jalankan PengurusSeeder terlebih dahulu.');
            return; // Jika tidak ada pengurus, tidak perlu membuat data koperasi
        }
        
        // Cari role koperasi
        $koperasiRole = Role::where('name', 'Koperasi')->first();
        
        if (!$koperasiRole) {
            $this->command->error('Role Koperasi tidak ditemukan. Silakan jalankan RoleSeeder terlebih dahulu.');
            return;
        }
        
        // Data koperasi
        $dataKoperasi = [
            [
                'nama_koperasi' => 'Koperasi Putra',
                'lokasi' => 'Gedung A, Lantai 1',
                'pengurus_id' => $pengurusIds[0], // Ahmad Fauzi
                'username' => 'koperasiputra',
                'email' => 'koperasi.putra@ponpes.com',
                'password' => 'koperasi123',
                'saldo_belanja' => 10000000.00
            ],
            [
                'nama_koperasi' => 'Koperasi Putri',
                'lokasi' => 'Gedung B, Lantai 1',
                'pengurus_id' => $pengurusIds[1], // Siti Aminah
                'username' => 'koperasiputri',
                'email' => 'koperasi.putri@ponpes.com',
                'password' => 'koperasi123',
                'saldo_belanja' => 8000000.00
            ],
            [
                'nama_koperasi' => 'Koperasi Umum',
                'lokasi' => 'Gedung Utama, Lantai 2',
                'pengurus_id' => $pengurusIds[2], // Muhammad Rizki
                'username' => 'koperasiumum',
                'email' => 'koperasi.umum@ponpes.com',
                'password' => 'koperasi123',
                'saldo_belanja' => 15000000.00
            ],
        ];
        
        // Hapus data koperasi dan user yang sudah ada sebelumnya
        foreach ($dataKoperasi as $data) {
            $oldUser = User::where('email', $data['email'])->first();
            if ($oldUser) {
                $oldKoperasi = DataKoperasi::where('user_id', $oldUser->id)->first();
                if ($oldKoperasi) {
                    $oldKoperasi->delete();
                }
                $oldUser->delete();
                $this->command->info("Data lama {$data['email']} dihapus.");
            }
        }
        
        // Masukkan data koperasi
        foreach ($dataKoperasi as $data) {
            // Buat user untuk koperasi
            $user = User::create([
                'name' => $data['nama_koperasi'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role_id' => $koperasiRole->id,
            ]);
            
            // Buat koperasi dan link dengan user
            $koperasi = DataKoperasi::create([
                'nama_koperasi' => $data['nama_koperasi'],
                'lokasi' => $data['lokasi'],
                'pengurus_id' => $data['pengurus_id'],
                'username' => $data['username'],
                'password_hash' => Hash::make($data['password']),
                'saldo_belanja' => $data['saldo_belanja'],
                'keuntungan' => 0,
                'user_id' => $user->id
            ]);
            
            $this->command->info("Koperasi '{$data['nama_koperasi']}' berhasil dibuat dengan username: {$data['username']}");
            $this->command->info("Email: {$data['email']}");
            $this->command->info("Password: {$data['password']}");
        }
    }
}

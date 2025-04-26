<?php

namespace Database\Seeders;

use App\Models\Pengurus;
use App\Models\Divisi;
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class PengurusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada divisi terlebih dahulu
        $divisiIds = Divisi::pluck('id')->toArray();
        
        // Jika tidak ada divisi, buat satu divisi default
        if (empty($divisiIds)) {
            $divisi = Divisi::create([
                'nama' => 'Divisi Koperasi',
                'sub_divisi' => 'Koperasi Pondok',
                'deskripsi' => 'Mengelola koperasi dan kebutuhan santri'
            ]);
            $divisiIds[] = $divisi->id;
        }
        
        // Dapatkan role pengurus
        $pengurusRole = Role::where('name', 'Pengurus')->first();
        if (!$pengurusRole) {
            $pengurusRole = Role::create([
                'name' => 'Pengurus',
                'description' => 'Memiliki akses view-only ke sistem'
            ]);
        }
        
        // Data pengurus
        $pengurus = [
            [
                'nama' => 'Ahmad Fauzi',
                'nik' => '3275012345678901',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1990-05-15',
                'telepon' => '081234567890',
                'kelurahan_domisili' => 'Cilandak',
                'kecamatan_domisili' => 'Cilandak',
                'kota_domisili' => 'Jakarta Selatan',
                'kelurahan_kk' => 'Cilandak',
                'kecamatan_kk' => 'Cilandak',
                'kota_kk' => 'Jakarta Selatan',
                'jabatan' => 'Ketua',
                'sub_divisi' => 'Koperasi Putra',
                'divisi_id' => $divisiIds[0],
                'email' => 'ahmadfauzi@ponpes.com'
            ],
            [
                'nama' => 'Siti Aminah',
                'nik' => '3275012345678902',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '1992-08-20',
                'telepon' => '082345678901',
                'kelurahan_domisili' => 'Cibiru',
                'kecamatan_domisili' => 'Cibiru',
                'kota_domisili' => 'Bandung',
                'kelurahan_kk' => 'Cibiru',
                'kecamatan_kk' => 'Cibiru',
                'kota_kk' => 'Bandung',
                'jabatan' => 'Sekretaris',
                'sub_divisi' => 'Koperasi Putri',
                'divisi_id' => $divisiIds[0],
                'email' => 'sitiaminah@ponpes.com'
            ],
            [
                'nama' => 'Muhammad Rizki',
                'nik' => '3275012345678903',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '1988-11-10',
                'telepon' => '083456789012',
                'kelurahan_domisili' => 'Gubeng',
                'kecamatan_domisili' => 'Gubeng',
                'kota_domisili' => 'Surabaya',
                'kelurahan_kk' => 'Gubeng',
                'kecamatan_kk' => 'Gubeng',
                'kota_kk' => 'Surabaya',
                'jabatan' => 'Bendahara',
                'sub_divisi' => 'Koperasi Putra',
                'divisi_id' => $divisiIds[0],
                'email' => 'muhammadrizki@ponpes.com'
            ],
        ];

        // Masukkan data pengurus
        foreach ($pengurus as $data) {
            $email = $data['email'];
            unset($data['email']);
            
            // Check if user already exists
            $existingUser = User::where('email', $email)->first();
            
            if ($existingUser) {
                $this->command->info("User with email {$email} already exists, skipping creation.");
                continue;
            }
            
            // Buat user untuk pengurus
            $user = User::create([
                'name' => $data['nama'],
                'email' => $email,
                'password' => Hash::make('pengurus123'),
                'role_id' => $pengurusRole->id
            ]);
            
            // Set user_id pada data pengurus
            $data['user_id'] = $user->id;
            
            // Buat pengurus
            Pengurus::create($data);
            
            $this->command->info("Created user and pengurus for {$data['nama']} with email {$email}");
        }
    }
}

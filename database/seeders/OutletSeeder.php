<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\DataKoperasi;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class KoperasiSeeder extends Seeder
{
    public function run(): void
    {
        $koperasiRole = Role::where('name', 'Koperasi')->first();

        if (!$koperasiRole) {
            $koperasiRole = Role::create([
                'name' => 'Koperasi',
                'description' => 'Memiliki akses ke fitur kantin dan koperasi'
            ]);
        }

        $koperasis = [
            [
                'name' => 'Kantin Putra',
                'email' => 'kantinputra@ponpes.com',
                'password' => Hash::make('koperasi123'),
                'role_id' => $koperasiRole->id,
                'koperasi_data' => [
                    'nama_koperasi' => 'Kantin Putra',
                    'lokasi' => 'Gedung Putra Lt. 1',
                    'saldo_belanja' => 5000000,
                    'keuntungan' => 0
                ]
            ],
            [
                'name' => 'Kantin Putri',
                'email' => 'kantinputri@ponpes.com',
                'password' => Hash::make('koperasi123'),
                'role_id' => $koperasiRole->id,
                'koperasi_data' => [
                    'nama_koperasi' => 'Kantin Putri',
                    'lokasi' => 'Gedung Putri Lt. 1',
                    'saldo_belanja' => 5000000,
                    'keuntungan' => 0
                ]
            ],
        ];

        foreach ($koperasis as $koperasi) {
            $userData = [
                'name' => $koperasi['name'],
                'email' => $koperasi['email'],
                'password' => $koperasi['password'],
                'role_id' => $koperasi['role_id']
            ];
            
            $user = User::create($userData);
            
            $koperasiData = $koperasi['koperasi_data'];
            $koperasiData['user_id'] = $user->id;
            $koperasiData['username'] = explode('@', $koperasi['email'])[0];
            $koperasiData['password_hash'] = Hash::make('koperasi123');
            
            DataKoperasi::create($koperasiData);
        }
    }
} 
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan role Admin sudah ada
        $adminRole = Role::where('name', 'Admin')->first();

        if (!$adminRole) {
            $adminRole = Role::create([
                'name' => 'Admin',
                'description' => 'Memiliki akses ke fitur administratif'
            ]);
        }

        // Buat user admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@ponpes.com',
            'password' => Hash::make('admin123'),
            'role_id' => $adminRole->id
        ]);
    }
    
}

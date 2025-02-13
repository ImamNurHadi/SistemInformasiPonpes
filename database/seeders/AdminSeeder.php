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
        // Pastikan role Super Admin sudah ada
        $superAdminRole = Role::where('name', 'Super Admin')->first();

        if (!$superAdminRole) {
            $superAdminRole = Role::create([
                'name' => 'Super Admin',
                'description' => 'Memiliki akses penuh ke seluruh fitur sistem'
            ]);
        }

        // Buat user admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@ponpes.com',
            'password' => Hash::make('admin123'),
            'role_id' => $superAdminRole->id
        ]);
    }
}

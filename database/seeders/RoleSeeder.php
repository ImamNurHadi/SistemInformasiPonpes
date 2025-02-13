<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Super Admin',
                'description' => 'Memiliki akses penuh ke seluruh fitur sistem'
            ],
            [
                'name' => 'Admin',
                'description' => 'Memiliki akses ke fitur administratif'
            ],
            [
                'name' => 'Pengurus',
                'description' => 'Memiliki akses ke fitur pengelolaan santri dan kamar'
            ],
            [
                'name' => 'Santri',
                'description' => 'Memiliki akses terbatas ke fitur untuk santri'
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
} 
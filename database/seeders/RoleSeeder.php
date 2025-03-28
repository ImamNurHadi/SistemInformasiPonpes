<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Admin',
                'description' => 'Memiliki akses penuh ke sistem kecuali top up saldo'
            ],
            [
                'name' => 'Pengurus',
                'description' => 'Memiliki akses view-only ke sistem'
            ],
            [
                'name' => 'Koperasi',
                'description' => 'Memiliki akses ke manajemen kantin dan koperasi'
            ],
            [
                'name' => 'Operator',
                'description' => 'Memiliki akses khusus untuk top up saldo'
            ],
            [
                'name' => 'Santri',
                'description' => 'Memiliki akses ke fitur santri'
            ],
            [
                'name' => 'Supplier',
                'description' => 'Memiliki akses ke fitur supplier untuk menyediakan barang'
            ]
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['name' => $role['name']],
                $role
            );
        }
    }
} 
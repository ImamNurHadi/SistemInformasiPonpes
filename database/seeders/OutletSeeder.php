<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class OutletSeeder extends Seeder
{
    public function run(): void
    {
        $outletRole = Role::where('name', 'Outlet')->first();

        if (!$outletRole) {
            $outletRole = Role::create([
                'name' => 'Outlet',
                'description' => 'Memiliki akses ke fitur kantin'
            ]);
        }

        $outlets = [
            [
                'name' => 'Kantin 1',
                'email' => 'kantin1@ponpes.com',
                'password' => Hash::make('kantin123'),
                'role_id' => $outletRole->id
            ],
            [
                'name' => 'Kantin 2',
                'email' => 'kantin2@ponpes.com',
                'password' => Hash::make('kantin123'),
                'role_id' => $outletRole->id
            ],
        ];

        foreach ($outlets as $outlet) {
            User::create($outlet);
        }
    }
} 
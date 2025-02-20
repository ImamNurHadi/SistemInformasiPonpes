<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class OperatorSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan role Operator sudah ada
        $operatorRole = Role::where('name', 'Operator')->first();

        if (!$operatorRole) {
            $operatorRole = Role::create([
                'name' => 'Operator',
                'description' => 'Memiliki akses khusus untuk top up saldo'
            ]);
        }

        // Buat atau update user operator
        User::updateOrCreate(
            ['email' => 'operator@ponpes.com'],
            [
                'name' => 'Operator',
                'password' => Hash::make('operator123'),
                'role_id' => $operatorRole->id
            ]
        );
    }
} 
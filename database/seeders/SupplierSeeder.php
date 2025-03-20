<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cari role supplier
        $supplierRole = Role::where('name', 'Supplier')->first();
        
        if (!$supplierRole) {
            $this->command->error('Role Supplier tidak ditemukan. Silakan jalankan migrasi add_role_koperasi_supplier terlebih dahulu.');
            return;
        }
        
        // Buat beberapa supplier
        $suppliers = [
            [
                'nama_supplier' => 'PT Supplier Utama',
                'alamat' => 'Jl. Supplier No. 1, Jakarta',
                'telepon' => '081234567890',
                'email' => 'supplier.utama@example.com',
                'username' => 'supplierutama',
                'password' => 'password123',
                'saldo_belanja' => 5000000.00,
            ],
            [
                'nama_supplier' => 'CV Supplier Jaya',
                'alamat' => 'Jl. Supplier No. 2, Bandung',
                'telepon' => '081234567891',
                'email' => 'supplier.jaya@example.com',
                'username' => 'supplierjaya',
                'password' => 'password123',
                'saldo_belanja' => 3000000.00,
            ],
            [
                'nama_supplier' => 'UD Supplier Makmur',
                'alamat' => 'Jl. Supplier No. 3, Surabaya',
                'telepon' => '081234567892',
                'email' => 'supplier.makmur@example.com',
                'username' => 'suppliermakmur',
                'password' => 'password123',
                'saldo_belanja' => 2000000.00,
            ],
        ];
        
        foreach ($suppliers as $supplierData) {
            // Buat user untuk supplier
            $user = User::create([
                'name' => $supplierData['nama_supplier'],
                'email' => $supplierData['email'],
                'password' => Hash::make($supplierData['password']),
                'role_id' => $supplierRole->id,
            ]);
            
            // Buat supplier dan link dengan user
            $supplier = Supplier::create([
                'nama_supplier' => $supplierData['nama_supplier'],
                'alamat' => $supplierData['alamat'],
                'telepon' => $supplierData['telepon'],
                'email' => $supplierData['email'],
                'username' => $supplierData['username'],
                'password_hash' => Hash::make($supplierData['password']),
                'saldo_belanja' => $supplierData['saldo_belanja'],
                'user_id' => $user->id,
            ]);
            
            $this->command->info("Supplier '{$supplierData['nama_supplier']}' berhasil dibuat dengan username: {$supplierData['username']}");
        }
    }
}

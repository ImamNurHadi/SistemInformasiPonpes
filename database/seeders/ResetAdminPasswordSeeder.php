<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetAdminPasswordSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@ponpes.com')->first();
        
        if ($admin) {
            $admin->update([
                'password' => Hash::make('admin123')
            ]);
            
            $this->command->info('Admin password has been reset successfully!');
        } else {
            $this->command->error('Admin user not found!');
        }
    }
} 
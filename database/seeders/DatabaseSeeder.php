<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            AdminSeeder::class,
            OutletSeeder::class,
            OperatorSeeder::class,
            MasterTingkatanSeeder::class,
            KomplekSeeder::class,
            KamarSeeder::class,
            SantriSeeder::class,
            PengurusSeeder::class,
            DataKoperasiSeeder::class,
        ]);
    }
}

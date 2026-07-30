<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            UserSeeder::class,
            QuickUsersSeeder::class,
            KategoriSeeder::class,
            SatuanSeeder::class,
            SupplierSeeder::class,
            ProyekSeeder::class,
            BarangSeeder::class,
            NotificationSeeder::class,
        ]);
    }
}

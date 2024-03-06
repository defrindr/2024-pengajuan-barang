<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Seeders\Iam\RoleSeeder;
use Database\Seeders\Iam\UserSeeder;
use Database\Seeders\Inventaris\InventarisSeeder;
use Database\Seeders\Inventaris\KategoriSeeder;
use Database\Seeders\Inventaris\RakSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            /** Module IAM */
            RoleSeeder::class,
            UserSeeder::class,

            // Modale Inventaris
            RakSeeder::class,
            KategoriSeeder::class,
            InventarisSeeder::class,
        ]);
    }
}

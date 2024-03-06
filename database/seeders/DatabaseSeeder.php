<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Seeders\Iam\RoleSeeder;
use Database\Seeders\Iam\UserSeeder;
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
        ]);
    }
}

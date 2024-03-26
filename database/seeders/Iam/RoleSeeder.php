<?php

namespace Database\Seeders\Iam;

use App\Models\Iam\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['id' => 1, 'name' => 'developer', 'description' => 'Access for developer only']);
        Role::create(['id' => 2, 'name' => 'vendor', 'description' => 'Access for vendor only']);
        Role::create(['id' => 3, 'name' => 'user', 'description' => 'Access for user only']);
    }
}

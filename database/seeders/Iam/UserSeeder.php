<?php

namespace Database\Seeders\Iam;

use App\Models\Iam\Role;
use App\Models\Iam\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username' => 'developer',
            'name' => 'Developer',
            'email_verified_at' => null,
            'password' => Hash::make('developer'),
            'email' => 'contact.developer@app.com',
            'photo' => User::DEFAULT_AVATAR,
            'role_id' => Role::where('name', 'developer')->first()->id,
        ]);
    }
}

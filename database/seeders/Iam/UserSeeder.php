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
        User::create([
            'username' => 'user',
            'name' => 'User',
            'email_verified_at' => null,
            'password' => Hash::make('user'),
            'email' => 'contact.user@app.com',
            'photo' => User::DEFAULT_AVATAR,
            'role_id' => Role::where('name', 'user')->first()->id,
        ]);
        User::create([
            'username' => 'vendor',
            'name' => 'vendor',
            'email_verified_at' => null,
            'password' => Hash::make('vendor'),
            'email' => 'contact.vendor@app.com',
            'photo' => User::DEFAULT_AVATAR,
            'role_id' => Role::where('name', 'vendor')->first()->id,
        ]);
    }
}

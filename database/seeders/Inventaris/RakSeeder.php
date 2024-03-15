<?php

namespace Database\Seeders\Inventaris;

use App\Models\Inventaris\Rak;
use Illuminate\Database\Seeder;

class RakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 26; $i++) {
            Rak::create(['name' => 'Rak ' . chr(65 + $i)]);
        }
    }
}

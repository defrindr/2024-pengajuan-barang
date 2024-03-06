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
        $names = ['Rak A', 'Rak B', 'Rak C'];

        foreach ($names as $name) {
            Rak::create(['name' => $name]);
        }
    }
}

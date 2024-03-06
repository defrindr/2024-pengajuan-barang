<?php

namespace Database\Seeders\Inventaris;

use App\Models\Inventaris\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'CA (Component Analis)',
            'SOT (System Owner Turbin)',
            'SOB (System Owner Boiler)',
        ];

        foreach ($categories as $category) {
            Kategori::create(['name' => $category]);
        }
    }
}

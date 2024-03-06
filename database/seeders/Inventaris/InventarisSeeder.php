<?php

namespace Database\Seeders\Inventaris;

use App\Models\Inventaris\Inventaris;
use App\Models\Inventaris\Kategori;
use App\Models\Inventaris\Rak;
use Illuminate\Database\Seeder;

class InventarisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            'Palu',
            'Gergaji',
            'Laptop',
        ];

        foreach ($items as $item) {
            Inventaris::create([
                'name' => $item,
                'stok' => random_int(1, 50),
                'category_id' => Kategori::inRandomOrder()->first()->id,
                'rak_id' => Rak::inRandomOrder()->first()->id,
            ]);
        }
    }
}

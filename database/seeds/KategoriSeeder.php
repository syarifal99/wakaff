<?php

use App\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kategori::create([
            'kategori' => 'Wakah Aset'
        ]);
        Kategori::create([
            'kategori' => 'Wakaf Tunai'
        ]);
    }
}

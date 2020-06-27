<?php

use App\Kota;
use Illuminate\Database\Seeder;

class KotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kota::create([
            'provinsi_id'   => 1,
            'kota'          => 'Malang',
        ]);
    }
}

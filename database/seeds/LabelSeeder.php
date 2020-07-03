<?php

use App\Label;
use Illuminate\Database\Seeder;

class LabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Label::create([
            'label' => 'Produktif'
        ]);
        Label::create([
            'label' => 'Non Produktif'
        ]);
    }
}

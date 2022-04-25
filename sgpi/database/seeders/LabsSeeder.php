<?php

namespace Database\Seeders;

use App\Models\Labs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LabsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Labs::create([
            'name' => 'Electrónica',
            'id_user' => 1
        ]);

        Labs::create([
            'name' => 'Manufactura y Automatización',
            'id_user' => 2
        ]);

        Labs::create([
            'name' => 'Mecánica',
            'id_user' => 3
        ]);

        Labs::create([
            'name' => 'Tecnologías Ambientales',
            'id_user' => 4
        ]);

        Labs::create([
            'name' => 'Fisicoquímica',
            'id_user' => 5
        ]);
    }
}

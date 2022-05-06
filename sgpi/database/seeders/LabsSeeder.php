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
            'id_user' => 9
        ]);

        Labs::create([
            'name' => 'Manufactura y Automatización',
            'id_user' => 5
        ]);

        Labs::create([
            'name' => 'Mecánica',
            'id_user' => 6
        ]);

        Labs::create([
            'name' => 'Tecnologías Ambientales',
            'id_user' => 8
        ]);

        Labs::create([
            'name' => 'Fisicoquímica',
            'id_user' => 7
        ]);
    }
}

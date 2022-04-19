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
        ]);

        Labs::create([
            'name' => 'Manufactura y Automatización',
        ]);

        Labs::create([
            'name' => 'Mecánica',
        ]);

        Labs::create([
            'name' => 'Tecnologías Ambientales',
        ]);

        Labs::create([
            'name' => 'Fisicoquímica',
        ]);
    }
}

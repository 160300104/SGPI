<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Angel Zalidvar Rodriguez',
            'email' => '160300104@ucaribe.edu.mx',
            'password' => bcrypt('12345678') 
        ])->assignRole('Admin');

        User::create([
            'name' => 'Jose Manuel Cazan Segura',
            'email' => '170300768@ucaribe.edu.mx',
            'password' => bcrypt('12345678') 
        ])->assignRole('Encargado');

        User::create([
            'name' => 'Mauricio De Leon Mercado',
            'email' => '170300104@ucaribe.edu.mx',
            'password' => bcrypt('12345678') 
        ])->assignRole('Becario');
        
        User::create([
            'name' => 'Estudiante 1',
            'email' => 'estudiante1@ucaribe.edu.mx',
            'password' => bcrypt('12345678') 
        ])->assignRole('Estudiante');

        User::create([
            'name' => 'Francisco Lopez Monzalvo',
            'email' => 'flopezm@ucaribe.edu.mx',
            'password' => bcrypt('12345678') 
        ])->assignRole('Encargado');

        User::create([
            'name' => 'Jarmen Said Virgen Suarez',
            'email' => 'jvirgen@ucaribe.edu.mx',
            'password' => bcrypt('12345678') 
        ])->assignRole('Encargado');

        User::create([
            'name' => 'Marina García Rosas',
            'email' => 'mgrosas@ucaribe.edu.mx',
            'password' => bcrypt('12345678') 
        ])->assignRole('Encargado');

        User::create([
            'name' => 'Víctor Manuel Romero Medina',
            'email' => 'vromero@ucaribe.edu.mx',
            'password' => bcrypt('12345678') 
        ])->assignRole('Encargado');

        User::create([
            'name' => 'Yarely Baez Lopez',
            'email' => 'ybaez@ucaribe.edu.mx',
            'password' => bcrypt('12345678') 
        ])->assignRole('Encargado');


    }
}

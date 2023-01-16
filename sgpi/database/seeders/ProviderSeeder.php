<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Provider;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Provider::create([
            'name' => 'Steren',
            'email' => 'COMERCIAL@STEREN.COM.MX',
            'phone_number' => '9988400600',
            'location' => 'Av. José, López Portillo 619-Mz. 20, Lt. 15, 92, 77515 Cancún, Q.R.',
            'image' => 'test',
            'latitude' => '21.1656728420688',
            'length' => '-86.8424673366129',
        ]);

        Provider::create([
            'name' => 'Electronica Gonzalez',
            'email' => 'mktegonzalez@gmail.com',
            'phone_number' => '999 923 8956',
            'location' => 'Manzana, López Portillo 2-lote 36, 69, 77510 Cancún, Q.R.',
            'image' => 'test',
            'latitude' => '21.17240518218421',
            'length' => '-86.8306087320066',
        ]);

        Provider::create([
            'name' => 'Radioshack',
            'email' => 'sclientes@radioshack.com.mx',
            'phone_number' => '9988847273',
            'location' => ' Avenida Tulum Sur 260, Plaza Las Americas 87 y 88, Centro, 77500 Cancún, Q.R.',
            'image' => 'test',
            'latitude' => '21.146790281328673',
            'length' => '-86.82165224531845',
        ]);

        Provider::create([
            'name' => 'Electronica El Sol',
            'email' => 'test@gmail.com',
            'phone_number' => '9982682537',
            'location' => '77517, Av. Miguel Hidalgo 1047, 94, Cancún, Q.R.',
            'image' => 'test',
            'latitude' => '21.169689389219474',
            'length' => '-86.86028177184379',
        ]);

        Provider::create([
            'name' => 'B-tronic Electronica',
            'email' => 'b-tronic@hotmail.com',
            'phone_number' => '9982511178',
            'location' => 'Av. kabah 110 condominio Zacatecas local 4 mz 6, Benito Juárez lote 15, 31, 77508 Cancún, Q.R.',
            'image' => 'test',
            'latitude' => '21.15592893505244',
            'length' => '-86.84174122821487',
        ]);
    }
}

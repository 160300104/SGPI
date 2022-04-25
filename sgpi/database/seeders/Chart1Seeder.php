<?php

namespace Database\Seeders;

use App\Models\Chart1;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use mysqli;

class Chart1Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $db = mysqli_connect('localhost', 'root', '', 'sgpi');
        if($db){
            $consulta = "SELECT SUM(quantity) FROM materials WHERE id_lab = 1";
            $consulta2 = "SELECT SUM(quantity) FROM materials WHERE id_lab = 5";
            $consulta3 = "SELECT SUM(quantity) FROM materials WHERE id_lab = 2";
            $resultado = mysqli_query($db,$consulta);
            $resultado2 = mysqli_query($db,$consulta2);
            $resultado3 = mysqli_query($db,$consulta3);
            $row = $resultado -> fetch_array();
            $row2 = $resultado2 -> fetch_array();
            $row3 = $resultado3 -> fetch_array();
        }

        $data=[
            array('name'=>'Electrónica','quantity'=>$row[0]),
            array('name'=>'Fisico-Quimica','quantity'=>$row2[0]),
            array('name'=>'LAMA','quantity'=>$row3[0]),
        ];
        Chart1::insert($data);
    }
}

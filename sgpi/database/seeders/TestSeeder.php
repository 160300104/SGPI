<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Test;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $inc = include("con_db.php");
        if($inc){
            $consulta = "SELECT COUNT(id) FROM materials WHERE id_lab = 1";
            $consulta2 = "SELECT COUNT(id) FROM materials WHERE id_lab = 6";
            $resultado = mysqli_query($conex,$consulta);
            $resultado2 = mysqli_query($conex,$consulta2);
            $row = $resultado -> fetch_array();
            $row2 = $resultado2 -> fetch_array();
        }

        $data=[
            array('name'=>'Electronica','quantity'=>$row[0]),
            array('name'=>'Fisico-Quimica','quantity'=>$row2[0]),
        ];
        Test::insert($data);
    }
}


?>
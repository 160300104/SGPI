<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chart1;
use App\Models\Labs;
use App\Models\Materials;
use Illuminate\Support\Arr;
use mysqli;

class Chart1Controller extends Controller
{
    public function index(){
        // GRAFICA DE INVENTARIO POR LABPRATORIO
        $mat_electronica = Materials::where('id_lab',1)->sum('quantity');
        $mat_LAMA = Materials::where('id_lab',2)->sum('quantity');
        $mat_mecanica = Materials::where('id_lab',3)->sum('quantity');
        $mat_fisicoquimica = Materials::where('id_lab',5)->sum('quantity');

        $data=[
            array('name'=>'Electrónica','y'=>intval($mat_electronica)),
            array('name'=>'Fisicoquímica','y'=>intval($mat_fisicoquimica)),
            array('name'=>'Mecánica','y'=>intval($mat_mecanica)),
            array('name'=>'LAMA','y'=>intval($mat_LAMA))
        ];

        // $charts = Chart1::all();
        // $puntos = [];
        // foreach($charts as $chart){
        //     $puntos[] = ['name' => $chart['name'], 'y' => $chart['quantity']];
        // }

        // GRAFICA DE INVENTARIO POR CATEGORIAS
        $categoria_herramienta = Materials::where('id_category',1)->sum('quantity');
        $categoria_consumible = Materials::where('id_category',2)->sum('quantity');
        $data2=[
            array('name'=>'Herramientas','y'=>intval($categoria_herramienta)),
            array('name'=>'Consumibles','y'=>intval($categoria_consumible)),
        ];
        
        // $db = mysqli_connect('localhost', 'root', '', 'sgpi');
        // if($db){
        //     $consulta1 = "SELECT COUNT(id) FROM materials WHERE id_category = 1";
        //     $consulta2 = "SELECT COUNT(id) FROM materials WHERE id_category = 2";
        //     $resultado1 = mysqli_query($db,$consulta1);
        //     $resultado2 = mysqli_query($db,$consulta2);
        //     $row1 = $resultado1 -> fetch_array();
        //     $row2 = $resultado2 -> fetch_array();

        //     $data2=[
        //         array('name'=>'Herramientas','y'=>intval($row1[0])),
        //         array('name'=>'Consumibles','y'=>intval($row2[0])),
        //     ];            
        // }
        // return view("Statistics.index", ["data" => json_encode($data), "data2" => json_encode($data2)]);
    }
}

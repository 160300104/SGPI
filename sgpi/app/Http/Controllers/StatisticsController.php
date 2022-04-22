<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Labs;
use App\Models\Materials;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class StatisticsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // GRAFICA DE INVENTARIO POR CATEGORIAS
        $total_cats = Categories::all()->count('id');
        for($i=1; $i<=$total_cats; $i++){
            ${"mat_cat" . $i} = Materials::where('id_category',$i)->sum('quantity');
            ${"cat_name" . $i} = Categories::where('id', $i)->value('name');
            $data[] = ['name' => ${"cat_name" . $i},'y'=>intval(${"mat_cat" . $i})];
        }
        // $categoria_herramienta = Materials::where('id_category',1)->sum('quantity');
        // $categoria_consumible = Materials::where('id_category',2)->sum('quantity');
        // $data=[
        //     array('name'=>'Herramientas','y'=>intval($categoria_herramienta)),
        //     array('name'=>'Consumibles','y'=>intval($categoria_consumible)),
        // ];

        // GRAFICA DE INVENTARIO POR LABORATORIO
        $total_labs = Labs::all()->count('id');
        $total_cats = Categories::all()->count('id');
        for($i=1; $i<=$total_labs; $i++){
            $labs_name[] = [Labs::where('id', $i)->value('name')];
            for($j=1; $j<=$total_cats; $j++){
                if (($j % 2) == 0) {
                    ${"cat_mat" . $i} = Materials::where('id_category', $j)->where('id_lab', $i)->sum('quantity');
                    $cons_mat_arr[] = [intval(${"cat_mat" . $i})];
                } else{
                    ${"cat_mat" . $i} = Materials::where('id_category', $j)->where('id_lab', $i)->sum('quantity');
                    $herr_mat_arr[] = [intval(${"cat_mat" . $i})];
                }
            }
        }

        // MÉTRICAS
        $metrica_mats_almacenados = intval(Materials::sum('quantity'));

        return view("Statistics.index", ["data" => json_encode($data), "herr_mat_arr" => json_encode($herr_mat_arr), "cons_mat_arr" => json_encode($cons_mat_arr), "labs_name" => json_encode($labs_name), "metrica_mats_almacenados" => json_encode($metrica_mats_almacenados)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

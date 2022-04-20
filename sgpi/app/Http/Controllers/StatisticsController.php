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
        // GRAFICA DE INVENTARIO POR LABPRATORIO
        $total_labs = Labs::all()->count('id');
        for($i=1; $i<=$total_labs; $i++){
            ${"mat_lab" . $i} = Materials::where('id_lab',$i)->sum('quantity');
            ${"lab_name" . $i} = Labs::where('id', $i)->value('name');
            $data[] = ['name' => ${"lab_name" . $i},'y'=>intval(${"mat_lab" . $i})];
        }
        
        // $mat_electronica = Materials::where('id_lab',1)->sum('quantity');
        // $mat_LAMA = Materials::where('id_lab',2)->sum('quantity');
        // $mat_mecanica = Materials::where('id_lab',3)->sum('quantity');
        // $mat_fisicoquimica = Materials::where('id_lab',5)->sum('quantity');

        // $data=[
        //     array('name'=>'Electrónica','y'=>intval($mat_electronica)),
        //     array('name'=>'Fisicoquímica','y'=>intval($mat_fisicoquimica)),
        //     array('name'=>'Mecánica','y'=>intval($mat_mecanica)),
        //     array('name'=>'LAMA','y'=>intval($mat_LAMA))
        // ];

        // GRAFICA DE INVENTARIO POR CATEGORIAS
        $total_cats = Categories::all()->count('id');
        for($i=1; $i<=$total_cats; $i++){
            ${"mat_cat" . $i} = Materials::where('id_category',$i)->sum('quantity');
            ${"cat_name" . $i} = Categories::where('id', $i)->value('name');
            $data2[] = ['name' => ${"cat_name" . $i},'y'=>intval(${"mat_cat" . $i})];
        }

        // $categoria_herramienta = Materials::where('id_category',1)->sum('quantity');
        // $categoria_consumible = Materials::where('id_category',2)->sum('quantity');
        // $data2=[
        //     array('name'=>'Herramientas','y'=>intval($categoria_herramienta)),
        //     array('name'=>'Consumibles','y'=>intval($categoria_consumible)),
        // ];

        return view("Statistics.index", ["data" => json_encode($data), "data2" => json_encode($data2)]);
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

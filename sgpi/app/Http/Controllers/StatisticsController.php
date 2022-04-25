<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materials;
use App\Models\Statistics;

class StatisticsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // GRAFICA DE INVENTARIO POR LABORATORIO
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

        // GRAFICA DE INVENTARIO POR CATEGORIAS
        $categoria_herramienta = Materials::where('id_category',1)->sum('quantity');
        $categoria_consumible = Materials::where('id_category',2)->sum('quantity');
        $data2=[
            array('name'=>'Herramientas','y'=>intval($categoria_herramienta)),
            array('name'=>'Consumibles','y'=>intval($categoria_consumible)),
        ];

        return view("Statistics.index", ["data" => json_encode($data), "data2" => json_encode($data2)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('statistics.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'latitud' => 'required',
            'longitud' => 'required'
        ]);

        $provider2=$request->all();

        
        Statistics::create($provider2);

        return redirect('/statistics');
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

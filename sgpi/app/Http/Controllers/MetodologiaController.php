<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Labs;
use App\Models\Tickets;
use App\Models\Materials;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class MetodologiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $labs = Labs::all();

        return view('metodologia.index', compact('labs'));
    }

    public function getMetodologia(Request $request){
        
        
        function metodologia_materiales($materiales){
            $contador = 0;

            foreach($materiales as $material){
                $contador += $material->frecuencia;
                $material->acumulado = $contador;

            }
            $acumulado_final = $materiales[count($materiales)-1];

            $contador2 = 0;
            foreach($materiales as $material){
                $material->porcentaje = number_format((($material->frecuencia / $acumulado_final->acumulado) * 100),3);
                $contador2 += $material->porcentaje;
                $material->porcentaje_acumulado = number_format($contador2,3);
                if($material->porcentaje_acumulado <= 80){
                    $material->clasificacion = 'A';
                }
                elseif($material->porcentaje_acumulado <= 95){
                    $material->clasificacion = 'B';
                }
                else{
                    $material->clasificacion = 'C';
                }
            }
        }
        
        if(request()->ajax()){

            $materiales = Tickets::join('materials', 'tickets.id_material', '=', 'materials.id')
            ->selectRaw('materials.name, COUNT(materials.name) AS frecuencia, materials.id_lab')
            ->groupBy('materials.name')
            ->orderBy('frecuencia', 'desc')
            ->get();

            metodologia_materiales($materiales);
            
            return DataTables::of($materiales) 
            ->filter(function($query) use ($request) {
                if($request->has('id_lab') && !empty($request->get('id_lab'))){
                    // $lab = $request->get('id_lab');
                    $query->collection = Tickets::join('materials', 'tickets.id_material', '=', 'materials.id')
                    ->selectRaw('materials.name, COUNT(materials.name) AS frecuencia, materials.id_lab')
                    ->groupBy('materials.name')
                    ->orderBy('frecuencia', 'desc')
                    ->where('id_lab', $request->get('id_lab'))
                    ->get();
                    metodologia_materiales($query->collection);
                    $query->collection = $query->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['id_lab'], $request->get('id_lab')) ? true : false;
                    });
                }
            })
            ->make(true);
        }


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

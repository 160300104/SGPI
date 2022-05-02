<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Labs;
use App\Models\Tickets;
use App\Models\Materials;
use Yajra\DataTables\DataTables;

class MetodologiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $materiales = Materials::selectRaw('COUNT(name) AS quantity, name, id_lab as acumulado')
            ->join('tickets', 'tickets.id_material', '=', 'materials.id')
            ->groupBy('name')
            ->get();

            $contador = 0;

            foreach($materiales as $material){
                $contador += $material->quantity;
                $material->acumulado = $contador;

            }


            return $materiales;
        $labs = Labs::all();

        return view('metodologia.index', compact('labs'));
    }

    public function getMetodologia(Request $request){
        
        
        if(request()->ajax()){

            


            return DataTables::of($materiales) 
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

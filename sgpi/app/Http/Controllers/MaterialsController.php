<?php

namespace App\Http\Controllers;

use App\Models\Materials;
use App\Models\Labs;
use App\Models\Categories;
use Illuminate\Http\Request;

class MaterialsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $labs = Labs::all();
        $categories = Categories::all();
        $materials = Materials::all();
        return view('materials.index')->with('materials', $materials)->with('labs',$labs)->with('categories',$categories);;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $labs = Labs::all();
        $categories = Categories::all();
        return view('materials.create')->with('labs',$labs)->with('categories',$categories);
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
            'name' => 'required',
            'image' => 'required',
            'quantity' => 'required',
            'register_date' => 'required',
            'id_lab' => 'required',
            'id_category' => 'required'
        ]);

        $materials=$request->all();

        if($image=$request->file('image')){

            $name = date('ymdHis'). "." . $image->getClientOriginalExtension();
            $image->move('img/materials', $name);
            $materials['image'] = $name;

        }
        
        Materials::create($materials);

        return redirect('/materials');
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
        $labs = Labs::all();
        $categories = Categories::all();
        $materials = Materials::find($id);
        return view('materials.edit')->with('materials',$materials)->with('labs',$labs)->with('categories',$categories);
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
        $request->validate([
            'name' => 'required',
            'image' => 'required',
            'quantity' => 'required',
            'register_date' => 'required',
            'id_lab' => 'required',
            'id_category' => 'required'
        ]);

        $user = Materials::find($id);

        $materials=$request->all();

        if($image=$request->file('image')){

            $name = date('ymdHis'). "." . $image->getClientOriginalExtension();
            $image->move('img/materials', $name);
            $materials['image'] = $name;

        }
        
        $user->update($materials);

        return redirect('/materials');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $materials = Materials::find($id);
        $materials->delete(); 

        return redirect('/materials');
    }
}

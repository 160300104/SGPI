<?php

namespace App\Http\Controllers;

use App\Models\Labs;
use App\Models\User;
use Illuminate\Http\Request;

class LabsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:labs.index')->only('index');
        $this->middleware('can:labs.edit')->only('edit', 'update');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $labs = Labs::all();
        return view('labs.index', compact('labs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $labs = Labs::all();
        $users = User::role('Encargado')->get();
        return view('labs.create')->with('labs',$labs)->with('users',$users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $provider=$request->all();
        
        Labs::create($provider);

        return redirect('/labs');
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
        $lab = Labs::find($id);
        $users = User::role('Encargado')->get();
        return view('labs.edit')->with('lab',$lab)->with('users',$users);
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

        $lab = Labs::find($id);

        $Labs=$request->all();
        
        $lab->update($Labs);

        return redirect('/labs');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lab = Labs::find($id);
        $lab->delete(); 

        return redirect('/labs');
    }
}

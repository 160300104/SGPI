<?php

namespace App\Http\Controllers;

use App\Models\Materials;
use App\Models\Labs;
use App\Models\Categories;
use Illuminate\Http\Request;

class MaterialsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:materials.index')->only('index');
        $this->middleware('can:materials.create')->only('create', 'store');
        $this->middleware('can:materials.edit')->only('edit', 'update');
        $this->middleware('can:materials.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('materials.index');
    }

    public function getLab(Request $request)
    {
        if ($request->ajax()) {
            $id_lab = Labs::all();

            return response()->json($id_lab);
        }
    }

    public function getCategory(Request $request)
    {
        if ($request->ajax()) {
            $id_category = Categories::all();

            return response()->json($id_category);
        }
    }

    public function records(Request $request)
    {
        if ($request->ajax()) {

            if (request('std') && request('res')) {
                $filter = Materials::with(['lab','category'])->where('id_lab', '=', request('std'))->where('id_category', '=', request('res'))->get();
            } else {
                $filter = Materials::with(['lab','category'])->when(request('std'), function ($query) {
                    $query->where('id_lab', '=', request('std'));
                })
                    ->when(request('res'), function ($query) {
                        $query->where('id_category', '=', request('res'));
                    })
                    ->get();
            }

            return response()->json([
                'filter' => $filter
            ]);
        } else {
            abort(403);
        }
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

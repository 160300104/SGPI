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
    public function index(Request $request)
    {
        $materials = Materials::all();
        $labs = Labs::all();
        $categories = Categories::all();

        $id_lab = Materials::select('id_lab')
            ->groupBy('id_lab')
            ->get();

        $id_category = Materials::select('id_category')
            ->groupBy('id_category')
            ->get();

        return view('materials.index', compact('id_lab', 'id_category', 'materials', 'labs', 'categories'));

        // $laboratorio = $request->laboratorio;
        // $categoria = $request->categoria;
        // $labs = Labs::all();
        // $categories = Categories::all();
        // $materials = Materials::where('id_lab','LIKE','%'.$laboratorio.'%')
        // -> Where('id_category', 'LIKE', '%'.$categoria.'%')
        // ->paginate(10);
        // return view('materials.index')->with('materials', $materials)->with('labs',$labs)->with('categories',$categories)->with('laboratorio',$laboratorio)->with('categoria',$categoria);
    }

    public function getStandard(Request $request)
    {
        if ($request->ajax()) {
            $id_lab = Labs::all();

            return response()->json($id_lab);
        }
    }

    public function getResult(Request $request)
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
                $students = Materials::where('id_lab', '=', request('std'))->where('id_category', '=', request('res'))
                    // ->latest()
                    ->get();
            } else {
                $students = Materials::when(request('std'), function ($query) {
                    $query->where('id_lab', '=', request('std'));
                })
                    ->when(request('res'), function ($query) {
                        $query->where('id_category', '=', request('res'));
                    })
                    // ->latest()
                    ->get();
            }

            // if(request('res')){
                // $cats = Categories::where('id', '=', request('res'))->get();
                $cats = Categories::all();
            // }

            return response()->json([
                'cats' => $cats,
                'students' => $students
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

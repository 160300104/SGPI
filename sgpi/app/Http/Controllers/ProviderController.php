<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Labs;
use Illuminate\Http\Request;
use App\Models\Provider;
use DebugBar\DebugBar;
use Symfony\Component\ErrorHandler\Debug;

use function PHPSTORM_META\map;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $providers = Provider::paginate(5);
        return view('provider.index')->with('providers', $providers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('provider.create');
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
            'email' => 'required',
            'phone_number' => 'required',
            'location' => 'required'
        ]);

        $provider=$request->all();

        if($image=$request->file('image')){

            $name = date('ymdHis'). "." . $image->getClientOriginalExtension();
            $image->move('img/provider', $name);
            $provider['image'] = $name;

        }
        
        Provider::create($provider);

        return redirect('/provider');

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
        $provider = Provider::find($id);
        return view('provider.edit')->with('provider',$provider);
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
            'email' => 'required',
            'phone_number' => 'required',
            'location' => 'required'
        ]);

        $user = Provider::find($id);

        $provider=$request->all();

        if($image=$request->file('image')){

            $name = date('ymdHis'). "." . $image->getClientOriginalExtension();
            $image->move('img/provider', $name);
            $provider['image'] = $name;

        }
        
        $user->update($provider);

        return redirect('/provider');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $provider = Provider::find($id);
        $provider->delete(); 

        return redirect('/provider');
    }
}

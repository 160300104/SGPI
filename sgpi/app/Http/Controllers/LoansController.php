<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tickets;
use Yajra\DataTables\DataTables;
use App\Models\Labs;
use App\Models\Loan;
use App\Models\Materials;
use GuzzleHttp\Promise\Create;
use LengthException;

class LoansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($request->ajax()){

            $tickets = Tickets::with(['loan','material','loan.user','loan.lab','loan.status','loan.lab.user'])->get();

            return DataTables::of($tickets)->make(true);

        }

        return view('loans.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $labs = Labs::all();
        return view('loans.create')->with('labs',$labs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $loan=$request->all();
        
        $loancurrent = Loan::create($loan);

        $materials = Materials::where('id_lab',$loancurrent->id_lab)->get();

        return view('loans.ticket', compact('loancurrent','materials'));
    }

    public function saveticket(Request $request)
    {

        $loan = $request->input('id_loan');
        $ticketsjson = $request->except(['_token', 'id_loan']);

        foreach($ticketsjson as $ticket){
            $tickets[] = [$ticket];
        }

        for ($i=0; $i<=count($tickets);$i++) { 
            $x = $i + 1;
             if($x < count($tickets)){
                        Tickets::create([
                        'id_material' => implode($tickets[$i]),
                        'quantity' => implode($tickets[$x]),
                        'id_loan'=> $loan
                    ]);

                    $material = Materials::find(implode($tickets[$i]));
                    $material->quantity = $material->quantity - implode($tickets[$x]);
                    $material->save();
            }     
            $i++;
        }
       
        return view('loans.index');
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

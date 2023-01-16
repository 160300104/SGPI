<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tickets;
use Yajra\DataTables\DataTables;
use App\Models\Labs;
use App\Models\Loan;
use App\Models\Materials;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
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
        // $tickets = Tickets::with(['loan','material','loan.user','loan.lab','loan.status','loan.lab.user'])->getQuery();
        // return $tickets->where('loan.lab.id',1);
        $labs = Labs::all();

        return view('loans.index',compact('labs'));
    }

    public function getDatatable(Request $request){
        
        $user = auth()->user();

        if(request()->ajax()){
            
            if($user->hasRole('Encargado')  || $user->hasRole('Admin')){
                $tickets = Tickets::with(['loan','material','loan.user','loan.lab','loan.status','loan.lab.user'])->join('loans', 'tickets.id_loan', '=', 'loans.id');
            }else{
                $tickets = Tickets::with(['loan','material','loan.user','loan.lab','loan.status','loan.lab.user'])->join('loans', 'tickets.id_loan', '=', 'loans.id')->where('loans.id_user', auth()->user()->id);
            }
            
            return DataTables::of($tickets)    
                ->filter(function($query) use ($request) {
                    if($request->has('id_lab') && !empty($request->get('id_lab')) && !empty($request->get('start_date'))){
                        $query->where('loans.id_lab', $request->get('id_lab'))->where('loans.loan_date', $request->get('start_date'));
                    }
                    
                    elseif($request->has('id_lab') && !empty($request->get('id_lab'))){
                       $query->where('loans.id_lab', $request->get('id_lab'));
                    }

                    elseif(!empty($request->get('start_date'))){
                        $query->where('loans.loan_date', $request->get('start_date'));
                    }
                })       
                ->editColumn('loan.status.id', function($query){
                    return $query->loan->status->id == 1 ? '<span class="badge rounded-pill bg-warning text-dark">En Prestamo</span>' : '<span class="badge bg-success">Finalizado</span>';
                })
                ->rawColumns(['loan.status.id'])
                
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
        date_default_timezone_set('America/Mexico_City');
        $loancurrent = Loan::create([
            'loan_date' => date("Y-m-d"),
            'id_user'=> Auth::id(),
            'id_status' => 1,
            'id_lab' => $request->id_lab
        ]);

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
                    if($material->quantity - implode($tickets[$x]) < 0){                       
                        Loan::find($loan)->delete();
                        return redirect()->route('loans.create')->with('info', 'El material '.$material->name.' no tiene suficiente existencia en almacen.');
                    }
                    $material->quantity = $material->quantity - implode($tickets[$x]);
                    $material->save();
                    
            }     
            $i++;
        }
       
        $labs = Labs::all();

        return redirect('/loans');

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
        $loan = Loan::find($id);

        $tickets = Tickets::all()->where('id_loan', $loan->id);

        foreach($tickets as $ticket){
            $current = Materials::find($ticket->id_material);
            $quantity = $current->quantity + $ticket->quantity;
            $current->update(['quantity' => $quantity]);
        }

        $loan->update(['id_status' => 2]);

        return redirect('/loans');
    }
}

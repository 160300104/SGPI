<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Labs;
use App\Models\Materials;
use App\Models\Loan;
use App\Models\Tickets;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class StatisticsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:statistics.index')->only('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // GRAFICA DE INVENTARIO POR CATEGORIAS
        $total_cats = Categories::all()->count('id');
        for($i=1; $i<=$total_cats; $i++){
            ${"mat_cat" . $i} = Materials::where('id_category',$i)->sum('quantity');
            ${"cat_name" . $i} = Categories::where('id', $i)->value('name');
            $data[] = ['name' => ${"cat_name" . $i},'y'=>intval(${"mat_cat" . $i})];
        }
        // $categoria_herramienta = Materials::where('id_category',1)->sum('quantity');
        // $categoria_consumible = Materials::where('id_category',2)->sum('quantity');
        // $data=[
        //     array('name'=>'Herramientas','y'=>intval($categoria_herramienta)),
        //     array('name'=>'Consumibles','y'=>intval($categoria_consumible)),
        // ];

        // GRAFICA DE INVENTARIO POR LABORATORIO
        $total_labs = Labs::all()->count('id');
        $total_cats = Categories::all()->count('id');
        for($i=1; $i<=$total_labs; $i++){
            $labs_name[] = [Labs::where('id', $i)->value('name')];
            for($j=1; $j<=$total_cats; $j++){
                if (($j % 2) == 0) {
                    ${"cat_mat" . $i} = Materials::where('id_category', $j)->where('id_lab', $i)->sum('quantity');
                    $cons_mat_arr[] = [intval(${"cat_mat" . $i})];
                } else{
                    ${"cat_mat" . $i} = Materials::where('id_category', $j)->where('id_lab', $i)->sum('quantity');
                    $herr_mat_arr[] = [intval(${"cat_mat" . $i})];
                }
            }
        }

        // OBTENER LOS DATOS DEL FILTRO
        $all_labs = Labs::select('name', 'id')->get();
        $all_labs_arr = json_decode(json_encode($all_labs), true);
        for ($i=0; $i < count($all_labs_arr); $i++) { 
            $labs_arr[] = $all_labs_arr[$i]['name'];
        }
        $filtro_lab = $request->laboratorio;

        if($filtro_lab){
            $labsel = Labs::find($filtro_lab)->name;
        }
        else{
            $labsel= "Todos";
        }
        

        // MÉTRICAS
        if($filtro_lab){
            $metrica_mats_almacenados = intval(Materials::where('id_lab', $filtro_lab)->sum('quantity'));

            $metrica_prestamos_activos = Loan::where('id_status', 1)->where('id_lab', $filtro_lab)->count('id'); // SELECT COUNT(id) FROM loans WHERE id_status = 1 and id_lab = $filtro_lab

            $metrica_mats_prestamo = intval(Tickets::join('loans', 'tickets.id_loan', '=', 'loans.id')->where('id_status',1)->where('id_lab', $filtro_lab)->sum('quantity')); // SELECT SUM(quantity) FROM `tickets` INNER JOIN loans on tickets.id_loan = loans.id WHERE loans.id_status = 1;
            
            $metrica_mat_destacado = Materials::selectRaw('COUNT(name) AS quantity, name')
            ->join('tickets', 'tickets.id_material', '=', 'materials.id')
            -> where('id_lab', $filtro_lab)
            ->groupBy('name')
            ->get(); // SELECT name, COUNT(name) FROM materials INNER JOIN tickets on tickets.id_material = materials.id GROUP BY name;
        }else{
            $metrica_mats_almacenados = intval(Materials::sum('quantity'));

            $metrica_prestamos_activos = Loan::where('id_status', 1)->count('id'); // SELECT COUNT(id) FROM loans WHERE id_status = 1

            $metrica_mats_prestamo = intval(Tickets::join('loans', 'tickets.id_loan', '=', 'loans.id')->where('id_status',1)->sum('quantity')); // SELECT SUM(quantity) FROM `tickets` INNER JOIN loans on tickets.id_loan = loans.id WHERE loans.id_status = 1;

            $metrica_mat_destacado = Materials::selectRaw('COUNT(name) AS quantity, name')
            ->join('tickets', 'tickets.id_material', '=', 'materials.id')
            ->groupBy('name')
            ->get(); // SELECT name, COUNT(name) FROM materials INNER JOIN tickets on tickets.id_material = materials.id GROUP BY name;
        }

        $metrica_mat_destacado_json = json_decode(json_encode($metrica_mat_destacado), true);

        if(empty($metrica_mat_destacado_json)){
            $mat_destacado = "Dato no disponible";
        }
        else{
            $m = max($metrica_mat_destacado_json);
            $mat_destacado = $m['name'];
        }

        // REGRESIÓN LINEAL
        if($filtro_lab){
            $loan_date = Loan::selectRaw(('loan_date, COUNT(*) AS total_loans')) // SELECT loan_date, COUNT(*) AS total_loans FROM loans WHERE id_lab = $filtro_lab GROUP BY loan_date;
                ->where('id_lab', $filtro_lab)
                ->groupBy('loan_date')
                ->get();
        }else{
            $loan_date = Loan::selectRaw(('loan_date, COUNT(*) AS total_loans')) // SELECT loan_date, COUNT(*) AS total_loans FROM loans GROUP BY loan_date;
                ->groupBy('loan_date')
                ->get();
        }
        $loan_date_arr = json_decode(json_encode($loan_date), true);
        
        $total_loan = count($loan_date_arr);
        if(empty($loan_date_arr)){
            $x = array();
            $y = array();
        }else{
            for($i=0; $i<$total_loan; $i++){
                ${"loan_date_x" . $i} = $loan_date_arr[$i]['loan_date'];
                $x[] = ${"loan_date_x" . $i};
    
                ${"loan_date_y" . $i} = $loan_date_arr[$i]['total_loans'];
                $y[] = ${"loan_date_y" . $i};
            }
        }

        function regresionLineal($x, $y){
            $n = count($x);
            if (count($y) != $n){
                die("Los elementos en x no coinciden con los elementos en y");
            }
            $days = range(1, $n);
            $sumaX = array_sum($days);
            $sumaY = array_sum($y);
            
            $sumaXporX = 0;
            $sumaXporY = 0;
            
            for ($i=0; $i < $n; $i++) { 
                $sumaXporX += ($days[$i] * $days[$i]);
                $sumaXporY += ($days[$i] * $y[$i]);
            }
            $w = (($n * $sumaXporY) - ($sumaX * $sumaY)) / (($n * $sumaXporX) - ($sumaX * $sumaX));
            $b = ($sumaY - ($w * $sumaX)) / $n;
            // echo "n: " . $n . "<br>sumaX: " . $sumaX . "<br>sumaY: " . $sumaY . "<br>sumaXporX: " . $sumaXporX . "<br>sumaXporY: " . $sumaXporY . "<br>w: ". $w . "<br>b: " . $b;
            return array("b" => $b, "w" => $w);
        }
        $x_days = range(1, count($x));

        if(empty($loan_date_arr) || count($loan_date_arr) < 5){
            $prediccion = [];
            $datosPrediccion = [];
            $x_pred = $x;
            $final_date = end($x);
            for ($i=1; $i <= 5; $i++) { 
                $x_pred[] = date("Y-m-d",strtotime($final_date."+ ". $i ."days")); 
            }
        }else{
            $prediccion = regresionLineal($x, $y);
            // regresionLineal($x, $y);
            // exit;
            $w = $prediccion["w"];
            $b = $prediccion["b"];
            // $datosPrediccion = array();
            for ($i=0; $i < count($x_days)+5; $i++) { 
                $prestamo = $w*($i+1)+$b;
                // array_push($datosPrediccion, $prestamo);
                $datosPrediccion[] = ["x" => ($i), "y" => round($prestamo)];
            }
    
            // Predecir los siguientes 5 días
            $x_pred = $x;
            $final_date = end($x);
            for ($i=1; $i <= 5; $i++) { 
                $x_pred[] = date("Y-m-d",strtotime($final_date."+ ". $i ."days")); 
            }
        }

        // echo "<pre>";
        // var_dump($datosPrediccion);
        // var_dump($y);
        // echo date("Y-m-d",strtotime($final_date."+ 1 days")); 
        // var_dump($y);
        // var_dump($datosPrediccion);
        // echo "</pre>";
        // exit;

        return view("Statistics.index", ["data" => json_encode($data), "herr_mat_arr" => json_encode($herr_mat_arr), "cons_mat_arr" => json_encode($cons_mat_arr), "labs_name" => json_encode($labs_name), "metrica_mats_almacenados" => json_encode($metrica_mats_almacenados), "metrica_prestamos_activos" => json_encode($metrica_prestamos_activos), "metrica_mats_prestamo" => json_encode($metrica_mats_prestamo),"mat_destacado" => json_encode($mat_destacado), "y" => json_encode($y), "x_pred" => json_encode($x_pred), "x_days" => json_encode(end($x_days)), "datosPrediccion" => json_encode($datosPrediccion), 'labs_arr' => $labs_arr, 'labsel' => $labsel]);
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

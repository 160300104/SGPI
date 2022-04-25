<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;

class TestController extends Controller
{
    public function index(){
        $tests = Test::all();

        $puntos=[];
        foreach($tests as $test){
            $puntos[]=['name'=>$test['name'],'y'=>$test['quantity']];
        }
        return view("statistics.index",["data" => json_encode($puntos)]);
    }
}

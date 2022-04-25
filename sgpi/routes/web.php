<?php

use App\Http\Controllers\ProviderController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\MaterialsController;
use App\Http\Controllers\UserController;
use App\Models\Provider;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

#Route::get('statistics',[TestController::class,'index']);

Route::middleware(['auth:sanctum', 'verified'])->group( function () {
    Route::resource('/provider', ProviderController::class);
    #Route::resource('/statistics', StatisticsController::class);
    Route::resource('/statistics',StatisticsController::class);
    Route::resource('/materials', MaterialsController::class);
    Route::resource('/user', UserController::class);
    Route::get('/dash',function(){
        return view('dash.index');
    })->name('dash');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

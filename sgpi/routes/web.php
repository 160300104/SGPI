<?php

use App\Http\Controllers\ProviderController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\MaterialsController;
use App\Http\Controllers\LoansController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LabsController;
use App\Models\Provider;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Chart1Controller;

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



Route::middleware(['auth:sanctum', 'verified'])->group( function () {
    Route::resource('/provider', ProviderController::class);
    Route::resource('/statistics', statisticsController::class);
    Route::resource('/materials', MaterialsController::class);
    Route::resource('/loans', LoansController::class)->middleware('can:loans.index');
    Route::resource('/user', UserController::class);
    Route::resource('/labs', LabsController::class);
    Route::post('/loans/saveticket',[LoansController::class, 'saveticket'])->name('loans.saveticket');
    Route::get('/loans/datatable',[LoansController::class, 'datatable'])->name('loans.datatable');
    Route::get('getLab', [MaterialsController::class, 'getLab'])->name('getLab');
    Route::get('getCategory', [MaterialsController::class, 'getCategory'])->name('getCategory');
    Route::get('records', [MaterialsController::class, 'records'])->name('records');
    Route::get('/dash',function(){
        return view('dash.index');
    })->middleware('can:home.index')->name('dash');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('Statistics', [Chart1Controller::class, 'index']);

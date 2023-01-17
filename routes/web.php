<?php

use App\Http\Controllers\RecordController;
use App\Models\Record;
use Illuminate\Support\Facades\Route;

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

Route::get('/',function(){
    return redirect()->route('control.batch.index');
});
Route::put('movements',[RecordController::class,'moveSelectedToTarget'])->name('control.batch.movement');
Route::put('expedition',[RecordController::class,'updateExpeditionItemsSelected'])->name('control.batch.expedition');
Route::delete('exclusion',[RecordController::class,'deleteItemsSelected'])->name('control.batch.exclusion');
Route::get('search/{process}/{product?}', [RecordController::class,'filter'])->name('control.batch.filters'); 
Route::get('search', [RecordController::class,'search'])->name('control.batch.search'); 
Route::get('print',[RecordController::class,'print'])->name('control.batch.print');
Route::resource('registros', RecordController::class)->parameter('registros','record')->names('control.batch');

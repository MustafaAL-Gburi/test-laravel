<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// berufcontroller routes
use App\Http\Controllers\BerufController;

Route::get('/berufe', [BerufController::class, 'index'])->name('berufe.index');
Route::match(['get','post'], '/berufe/get_list', [BerufController::class, 'getList'])->name('berufe.getList');
Route::get('/beruf/edit/{id?}', [BerufController::class, 'edit'])->name('berufe.edit');
Route::post('/beruf/update/{id}', [BerufController::class, 'update'])->name('berufe.update');
Route::post('/beruf/store', [BerufController::class, 'store'])->name('berufe.store');
Route::get('/beruf/loeschen/{id}', [BerufController::class, 'delete'])->name('berufe.delete');
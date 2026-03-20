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

Route::get('/berufe', [BerufController::class, 'index']);
Route::match(['get','post'], '/berufe/get_list', [BerufController::class, 'get_list']);
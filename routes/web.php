<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers as Controller;

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
    return view('welcome');
});

Route::get("/document",[Controller\DocumentController::class,'index'])->name('document');

Route::get("/first",[Controller\DocumentController::class,'first'])->name('first');

Route::get("/second",[Controller\DocumentController::class,'second'])->name('second');
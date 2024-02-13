<?php

use App\Http\Controllers\DokumenController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('landing');
});

Route::get('/template', function () {
    return view('home');
})->middleware('auth');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('jenis', JenisController::class)->parameter('jenis','id');
Route::post('/get-jenis', [JenisController::class,'getJenis'])->name('jenis.getJenis');

Route::resource('users', UserController::class);
Route::post('/get-users', [UserController::class,'getUsers'])->name('users.getUsers');

Route::resource('dokumens',DokumenController::class)->parameter('dokumens','id');
Route::post('/get-doc-by-uname', [DokumenController::class, 'getDocByUName'])->name('dokumens.getDocByUName');

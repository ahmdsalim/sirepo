<?php

use App\Http\Controllers\DokumenController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\cekRole;
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

Route::middleware('auth')->group(function() {
    Route::resource('jenis', JenisController::class)->parameter('jenis','id');
    Route::post('/get-jenis', [JenisController::class,'getJenis'])->name('jenis.getJenis');
    
    Route::resource('users', UserController::class);
    Route::post('/get-users', [UserController::class,'getUsers'])->name('users.getUsers');
    // Route::get('/setting', [UserController::class, 'settingLanding'])->name('user.settingLanding');
    Route::group(['prefix' => 'setting'],function(){
        Route::match(['get', 'post'] , '/profil',[UserController::class, 'settingLanding'])->name('user.settingLanding');
        Route::match(['get', 'post'] , '/keamanan',[UserController::class, 'keamananLanding'])->name('user.keamananLanding');
    });

    Route::resource('dokumens',DokumenController::class)->parameter('dokumens','id');
    Route::post('/get-documents', [DokumenController::class, 'getDocuments'])->name('dokumens.getDocuments');

    Route::get('approve-users', [UserController::class, 'indexApprove'])->name('approve.index');
    Route::post('/get-approve-users', [UserController::class, 'getApproveUsers'])->name('getApproveUsers');
    Route::post('/set-approved-user', [UserController::class, 'setApprovedUser'])->name('setApprovedUser');
    Route::delete('/set-rejected-user/{username}', [UserController::class, 'setRejectedUser'])->name('setRejectedUser');

    // Route::get('profile', [UserController::class, 'profile'])->name('profile');
    Route::match(['get', 'post'] , '/profil',[UserController::class, 'profile'])->name('user.profile');
    Route::match(['get', 'post'] , '/profil',[UserController::class, 'profileLanding'])->name('user.profileLanding');
    Route::post('/update-profile', [UserController::class, 'updateProfile'])->name('profile.update');

    Route::get('security', [UserController::class, 'security'])->name('security');
    Route::post('/update-security', [UserController::class, 'securityUpdate'])->name('security.update');
});
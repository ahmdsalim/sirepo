<?php

use App\Http\Controllers\DokumenController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\cekRole;
use App\Models\User;
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
    return view('landing.landing');
})->name('landing');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('pencarian', [LandingController::class, 'search'])->name('landing.search');
Route::get('pencarian/nama', [LandingController::class, 'detail'])->name('landing.detail');

Route::middleware('auth')->group(function () {
    Route::middleware('authtype:super')->group(function () {
        Route::resource('jenis', JenisController::class)->parameter('jenis', 'id');
        Route::post('/get-jenis', [JenisController::class, 'getJenis'])->name('jenis.getJenis');

        Route::resource('users', UserController::class);
        Route::post('/get-users', [UserController::class, 'getUsers'])->name('users.getUsers');

        Route::get('approve-users', [UserController::class, 'indexApprove'])->name('approve.index');
        Route::post('/get-approve-users', [UserController::class, 'getApproveUsers'])->name('getApproveUsers');
        Route::post('/set-approved-user', [UserController::class, 'setApprovedUser'])->name('setApprovedUser');
        Route::delete('/set-rejected-user/{username}', [UserController::class, 'setRejectedUser'])->name('setRejectedUser');
        Route::post('/send-email-approved', [UserController::class, 'sendEmailApproved'])->name('sendEmailApproved');
    });

    Route::middleware('authtype:super.admin')->group(function () {
        Route::resource('dokumens', DokumenController::class)->parameter('dokumens', 'id');
        Route::post('/get-documents', [DokumenController::class, 'getDocuments'])->name('dokumens.getDocuments');

        Route::match(['get'], 'profile', [UserController::class, 'profile'])->name('profile');
        Route::post('/update-profile', [UserController::class, 'updateProfile'])->name('profile.update');

        Route::get('security', [UserController::class, 'security'])->name('security');
        Route::post('/update-security', [UserController::class, 'securityUpdate'])->name('security.update');
    });

    Route::middleware('authtype:user')->group(function () {
        Route::group(['prefix' => 'setting'], function () {
            Route::match(['get', 'post'], '/profile', [LandingController::class, 'setting'])->name('landing.setting');
            Route::match(['get', 'post'], '/keamanan', [LandingController::class, 'keamanan'])->name('landing.keamanan');
        });

        Route::match(['get'], 'user/profile', [LandingController::class, 'profile'])->name('landing.profile');
    });
});
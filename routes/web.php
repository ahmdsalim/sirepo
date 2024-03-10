<?php

use App\Models\User;
use App\Models\Dokumen;
use App\Models\Bookmark;
use App\Http\Middleware\cekRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\KoleksiController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\MahasiswaController;

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

Route::get('/', [LandingController::class, 'index'])->name('landing');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('search', [LandingController::class, 'search'])->name('landing.search');
Route::get('search-all', [LandingController::class, 'docAll'])->name('landing.dokumen');
Route::post('search/filter', [LandingController::class, 'filter'])->name('landing.filter');
Route::get('pencarian/{id}/{slug}', [LandingController::class, 'detail'])->name('landing.detail');
Route::get('contributors', function () {
    return view('contributors');
})->name('contributors');

Route::middleware('auth')->group(function () {
    Route::post('/update-profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::post('/update-security', [UserController::class, 'securityUpdate'])->name('security.update');

    Route::middleware('authtype:super')->group(function () {
        Route::resource('jenis', JenisController::class)
            ->parameter('jenis', 'id')
            ->except(['create', 'show']);
        Route::post('/get-jenis', [JenisController::class, 'getJenis'])->name('jenis.getJenis');

        Route::resource('users', UserController::class)->except(['create', 'show']);
        Route::post('/get-users', [UserController::class, 'getUsers'])->name('users.getUsers');

        Route::get('get-unsync-mahasiswa', [MahasiswaController::class, 'getUnsyncMhs'])->name('getUnsyncMhs');

        Route::put('update-user-active-status', [UserController::class, 'updateActiveStatus'])->name('updateUserActiveStatus');

        Route::resource('prodi', ProdiController::class)->except(['create', 'show']);
        Route::post('/get-prodi', [ProdiController::class, 'getProdi'])->name('prodi.getProdi');
    });

    Route::middleware('authtype:super.admin')->group(function () {
        Route::resource('dokumens', DokumenController::class)->parameter('dokumens', 'id')->except(['create', 'show']);
        Route::post('/get-documents', [DokumenController::class, 'getDocuments'])->name('dokumens.getDocuments');
        Route::post('/get-document-by-id', [DokumenController::class, 'getDocumentById'])->name('dokumens.getDocumentById');
        Route::delete('/destroy-file/{id}', [DokumenController::class, 'destroyFile'])->name('dokumens.destroyFile');
        Route::post('import-dokumen', [DokumenController::class, 'import'])->name('dokumens.import');
        Route::match(['get'], 'import-dokumen-error', [DokumenController::class, 'errorImport'])->name('dokumens.errorImport');
        Route::match(['get'], 'profile', [UserController::class, 'profile'])->name('profile');
        Route::get('security', [UserController::class, 'security'])->name('security');
        Route::resource('mahasiswas', MahasiswaController::class)->except(['create', 'show']);
        Route::post('get-mahasiswa', [MahasiswaController::class, 'getMahasiswa'])->name('mahasiswas.getMahasiswa');
        Route::post('import-mahasiswa', [MahasiswaController::class, 'import'])->name('mahasiswas.import');
        Route::get('import-mahasiswas-error', [MahasiswaController::class, 'errorImport'])->name('mahasiswas.errorImport');

        Route::put('update-mahasiswa-active-status', [MahasiswaController::class, 'updateActiveStatus'])->name('updateMahasiswaActiveStatus');

        Route::get('penelitian/file/{filename}', [DokumenController::class, 'getFile'])->name('file.get');
    });

    Route::middleware('authtype:user')->group(function () {
        Route::group(['prefix' => 'setting'], function () {
            Route::match(['get', 'post'], '/profile', [LandingController::class, 'setting'])->name('landing.setting');
            Route::match(['get', 'post'], '/keamanan', [LandingController::class, 'keamanan'])->name('landing.keamanan');
        });

        Route::group(['prefix' => 'api'], function () {
            Route::post('collection/collect', [KoleksiController::class, 'collect'])->name('api.collection.collect');
            Route::post('collection/uncollect', [KoleksiController::class, 'uncollect'])->name('api.collection.uncollect');
        });

        Route::match(['get'], 'user/profile', [LandingController::class, 'profile'])->name('landing.profile');
        Route::get('koleksi', [KoleksiController::class, 'index'])->name('landing.koleksi');
    });

    Route::get('penelitian/file/download/{filename}', [DokumenController::class, 'downloadFile'])->name('file.public.download');
});

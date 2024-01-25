<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KoleksiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BacaController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\Auth\RegisterController;
// use App\Models\Siswa;
use App\Http\Controllers\NotifikasiController;

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
Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('landing');
Route::get('/search', [BukuController::class, 'search'])->name('book.search');

Route::get('/buku/terbaru', [BukuController::class, 'bukuterbaru'])->name('bukuterbaru');
Route::get('/buku/terpopuler', [BukuController::class, 'bukuterpopuler'])->name('bukuterpopuler');

Auth::routes(['login','logout']);

Route::middleware('guest')->group(function() {
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
	Route::get('register/sekolah', [RegisterController::class, 'showFormSekolah'])->name('register.sekolah');
	Route::get('register/siswa', [RegisterController::class, 'showFormSiswa'])->name('register.siswa');
	Route::get('register/guru', [RegisterController::class, 'showFormGuru'])->name('register.guru');
	Route::post('register/sekolah/store', [RegisterController::class, 'registerSekolah'])->name('register.sekolah.store');
	Route::post('register/siswa/store', [RegisterController::class, 'registerSiswa'])->name('register.siswa.store');
	Route::post('register/guru/store', [RegisterController::class, 'registerGuru'])->name('register.guru.store');
	Route::get('register/verify/resend', [RegisterController::class, 'showResend'])->name('register.show.resend');
	Route::post('register/verify/resend', [RegisterController::class, 'resendEmail'])->middleware('throttle:2,1')->name('register.verify.resend');
	// Route::get('reset-email', [RegisterController::class, 'showResetEmail'])->name('reset.email.show');
	// Route::post('reset-email', [RegisterController::class, 'resetEmail'])->name('reset.email.post');
	Route::get('auth/aktivasi', [UserController::class, 'aktivasi'])->name('users.aktivasi');
	Route::get('auth/login-action', [RegisterController::class, 'login_action'])->name('login.action');
});	

//Akses User Owner CRUD dan Sekolah (Index)
//Special Treatment
Route::resource('users', UserController::class);

//API
Route::prefix('api')
    ->middleware('auth')
    ->group(function () {
        Route::get('getSekolah', [SekolahController::class, 'getSekolah'])->name('api.getSekolah');
        Route::get('getSiswa', [SiswaController::class, 'getSiswa'])->name('api.getSiswa');
        Route::get('getGuru', [GuruController::class, 'getGuru'])->name('api.getGuru');
        Route::post('read/save', [BacaController::class, 'save'])->name('api.read.save');
        Route::post('collection/collect', [KoleksiController::class, 'collect'])->name('api.collection.collect');
        Route::post('collection/uncollect', [KoleksiController::class, 'uncollect'])->name('api.collection.uncollect');
    });

Route::group(['middleware' => 'auth'], function() {

	Route::group(['middleware' => 'role:owner'], function() {
    	//Akses User Owner START >>
    	Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'home'])->name('home');

    	//CRUD Sekolah
	    Route::resource('sekolah', SekolahController::class);
	    Route::get('/export-sekolah', [SekolahController::class, 'export'])->name('sekolah.export');
        Route::get('sekolah/cetak/pdf', [SekolahController::class, 'cetakPdf'])->name('sekolah.cetak.pdf');

    	//Buku
    	Route::get('/request-publish', [BukuController::class, 'request'])->name('buku.request');
	    Route::put('/buku/request/{id}', [BukuController::class, 'requestUpdate'])->name('buku.requestUpdate');
	    Route::get('/export-req-posting', [BukuController::class, 'exportReqPosting'])->name('buku.req-posting.export');
	    
	    //Kategori 
	    Route::resource('kategori', KategoriController::class);
	    
	    //RUD Guru
	    Route::get('owner/{sekolah}/list-guru', [GuruController::class, 'getGuruBySekolah'])->name('owner.guru.index');
	    Route::get('owner/guru/{guru}/edit', [GuruController::class, 'editGuru'])->name('owner.guru.edit');
	    Route::put('owner/guru/{guru}/update', [GuruController::class, 'updateGuru'])->name('owner.guru.update');
	    Route::delete('owner/guru/{guru}/delete', [GuruController::class, 'destroyGuru'])->name('owner.guru.destroy');
	    //RUD Siswa
        Route::get('owner/sekolah/{sekolah}/list-siswa', [SiswaController::class, 'getSiswaBySekolah'])->name('owner.siswa.index');
        Route::get('owner/siswa/{siswa}/edit', [SiswaController::class, 'editSiswa'])->name('owner.siswa.edit');
        Route::put('owner/siswa/{siswa}/update', [SiswaController::class, 'updateSiswa'])->name('owner.siswa.update');
        Route::delete('owner/siswa/{siswa}/delete', [SiswaController::class, 'destroySiswa'])->name('owner.siswa.destroy');
        //Akses User Owner END <<
	});

    Route::group(['middleware' => 'role:owner,sekolah'], function() {
        //Akses Keduanya START >>
        //User
        Route::get('/export-user', [UserController::class, 'export'])->name('users.export');
	    Route::get('user/cetak-pdf', [UserController::class, 'cetakPdf'])->name('user.cetak.pdf');

	    //Profile
	    Route::get('/profile', [UserController::class, 'showProfile'])->name('users.profile');
	    Route::get('/change-password', [UserController::class, 'showChangePassword'])->name('users.changepassword.show');
	    Route::post('/change-password', [UserController::class, 'changePassword'])->name('users.changepassword.store');

	    //Pembaca
	    Route::get('list-pembaca', [BacaController::class, 'index'])->name('reader.index');
	    Route::get('list-pembaca/{id}/detail', [BacaController::class, 'detail'])->name('reader.detail');
	    Route::get('/export-pembaca', [BacaController::class, 'export'])->name('baca.export');
	    Route::get('pembaca/cetak-pdf', [BacaController::class, 'cetakPdf'])->name('pembaca.cetak.pdf');

        //Buku
        Route::resource('buku', BukuController::class);
        Route::get('buku/cetak/pdf', [BukuController::class, 'cetakPdf'])->name('buku.cetak.pdf');
        Route::get('/export-buku', [BukuController::class, 'export'])->name('buku.export');

        //Siswa Guru
        Route::get('/export-siswa', [SiswaController::class, 'export'])->name('siswa.export');
        Route::get('siswa/cetak/pdf', [SiswaController::class, 'cetakPdf'])->name('siswa.cetak.pdf');
        Route::get('/export-guru', [GuruController::class, 'export'])->name('guru.export');
        Route::get('guru/cetak/pdf', [GuruController::class, 'cetakPdf'])->name('guru.cetak.pdf');

        //Notifikasi
        Route::get('inbox', [NotifikasiController::class, 'index'])->name('inbox.index');
        Route::get('inbox/{id}', [NotifikasiController::class, 'show'])->name('inbox.show');
        Route::get('inbox/delete/{id}', [NotifikasiController::class, 'destroy'])->name('inbox.destroy');
        //Akses Keduanya END <<
    });
        
    Route::group(['middleware' => 'role:sekolah'], function() {

        //Akses User Sekolah START >>
        Route::get('/dashboard-sekolah', [App\Http\Controllers\HomeController::class, 'homesekolah'])->name('home.sekolah');

        //CRUD Siswa dan Guru
		Route::name('sekolah.')->group(function () {
		    Route::resource('siswa', SiswaController::class)->except('show');
		    Route::resource('guru', GuruController::class)->except('show');
		});

        Route::post('/import-siswa', [SiswaController::class, 'import'])->name('siswa.import');
        Route::get('/error-import-siswa', [SiswaController::class, 'errorImport'])->name('siswa.error-import');
        Route::post('/import-guru', [GuruController::class, 'import'])->name('guru.import');
        Route::get('/error-import-guru', [GuruController::class, 'errorImport'])->name('guru.error-import');

        //Buku
        Route::put('/buku/resend/{slug}', [BukuController::class, 'resend'])->name('buku.resend');
        //Akses User Sekolah END <<
	});
});

Route::middleware('auth.user')->group(function(){
	Route::get('akun/profil', [UserController::class, 'showProfilePembaca'])->name('pembaca.profile');
	Route::get('akun/ubah-password', [UserController::class, 'showChangePasswordPembaca'])->name('pembaca.changepassword.show');
	Route::post('akun/ubah-password', [UserController::class, 'changePasswordPembaca'])->name('pembaca.changepassword.store');
    
    Route::get('baca/{id}/{slug}', [BacaController::class, 'read'])->name('read');
    Route::get('/koleksi', [KoleksiController::class, 'index'])->name('koleksi');
    Route::get('/daftar-bacaan', [BacaController::class, 'readinglist'])->name('daftarbacaan');
    Route::resource('rating', RatingController::class)->only('store');
});

Route::get('detailbuku/{id}/{slug}', [BukuController::class, 'showdetail'])->name('buku.detailbuku');

// Route::get('/config-clear', function(){
//  \Illuminate\Support\Facades\Artisan::call('config:clear');
//  echo 'Caches cleared successfully!';
// });

//Route::get('/cache-clear', function(){
//  \Illuminate\Support\Facades\Artisan::call('cache:clear');
//  echo 'Cache cleared successfully!';
//});

//Route::get('/storage-link', function(){
//  \Illuminate\Support\Facades\Artisan::call('storage:link');
//  echo 'Storage linked successfully!';
//});

// Route::get('/createkoleksi/{id}', [KoleksiController::class, 'create']);

// Route::get('/terakhirdibaca', [BacaController::class, 'indexpembaca'])->name('terakhirdibaca');

// Route::post('/import', [SiswaController::class, 'import'])->name('siswa.import');
// Route::get('/export-siswa', [SiswaController::class, 'export'])->name('siswa.export');
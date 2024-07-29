<?php

use App\Models\Materi;
use App\Models\Member;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\LandingpageController;
use App\Http\Controllers\LogaktivitasController;

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

// Route::get('/', function () {
//     return view('post-dashboard.dashboard');
// });
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
// Auth::routes();
Route::middleware('guest')->group(function () {
    //Roots Login dan Logout
    Route::get('/', [LandingpageController::class, 'index'])->name('beranda'); //fungsi name = mengubah nama route 
    Route::get('/tentangkami', [LandingpageController::class, 'tentangkami'])->name('tentangkami'); //fungsi name = mengubah nama route 
    Route::get('/kategoritraining', [LandingpageController::class, 'kategoritraining'])->name('kategoritraining'); //fungsi name = mengubah nama route 
    Route::get('/detailkategori/{id}', [LandingpageController::class, 'detailkategori'])->name('detailkategori'); //fungsi name = mengubah nama route 
    Route::get('/kontak', [LandingpageController::class, 'kontak'])->name('kontak');
    Route::post('/kontakemail', [LandingpageController::class, 'kirimEmail'])->name('kirimemail');
    Route::get('/login', [AuthController::class, 'index'])->name('login'); //fungsi name = mengubah nama route 
    Route::post('proseslogin', [AuthController::class, 'proseslogin'])->name('proseslogin');
    Route::get('/resetpassword', [AuthController::class, 'resetpassword'])->name('resetpassword');
    Route::get('/registerasi', [AuthController::class, 'registrasi'])->name('registrasi');
    Route::post('/proses-registrasi', [AuthController::class, 'prosesregistrasi'])->name('prosesregistrasi');
    Route::get('/lupa-password', [AuthController::class, 'lupaPassword'])->name('lupaPassword');
    Route::post('/lupa-password', [AuthController::class, 'processLupaPassword'])->name('processlupaPassword');
    Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'processResetPassword'])->name('processResetPassword');
});


Route::middleware('auth:admin')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/datacoach', [CoachController::class, 'index'])->name('datacoach');
    // Route untuk menampilkan formulir tambah
    Route::get('/tambah-coach', [CoachController::class, 'create'])->name('tambahcoach');
    // Route untuk menyimpan data
    Route::post('/coach-insert', [CoachController::class, 'store'])->name('coach-insert');
    Route::delete('/delete_coach/{id}', [CoachController::class, 'delete'])->name('coach.delete');

    Route::get('/datamember', [MemberController::class, 'index'])->name('datamember');
    Route::delete('/delete_member/{id}', [MemberController::class, 'delete'])->name('member.delete');

    Route::get('/datamateri', [MateriController::class, 'materi'])->name('datamateri');
    Route::get('/datamateri/{id}', [MateriController::class, 'lihat'])->name('lihatmateri');
    Route::get('/tambah-materi', [MateriController::class, 'create'])->name('tambahmateri');
    Route::post('/materi-insert', [MateriController::class, 'store'])->name('materi-insert');
    Route::get('/edit-materi/{id}', [MateriController::class, 'editmateri'])->name('editmateri');
    Route::put('/materi-update/{id}', [MateriController::class, 'updatemateri'])->name('materi-update');
    Route::delete('/delete_materi/{id}', [MateriController::class, 'deletemateri'])->name('materi-delete');

    Route::get('/tambah-kategori', [MateriController::class, 'tambahkategori'])->name('tambahkategori');
    Route::post('/kategori-insert', [MateriController::class, 'insertkategori'])->name('kategori-insert');
    Route::get('/edit-kategori/{id}', [MateriController::class, 'editkategori'])->name('editkategori');
    Route::put('/kategori-update/{id}', [MateriController::class, 'updatekategori'])->name('kategori-update');
    Route::delete('/delete_kategori/{id}', [MateriController::class, 'deletekategori'])->name('kategori-delete');

    Route::get('/data-logaktivitas', [LogaktivitasController::class, 'logaktivitas'])->name('data-logaktivitas');
    Route::get('/lihat-logaktivitas/{logaktivitasid}', [LogaktivitasController::class, 'lihatlogaktivitas'])->name('lihatlogaktivitas');
    Route::get('lihat-materi/{tahun}/{bulan}/{materi}', [LogaktivitasController::class, 'lihatcetakmateri'])->name('lihatlapmateri');
    Route::get('/profil-admin', [AdminController::class, 'profiladmin'])->name('profiladmin');
    Route::put('/profile-editadmin', [AdminController::class, 'updateadmin'])->name('updateadmin');
    Route::post('/ubah-password-admin', [AuthController::class, 'ubahpassword'])->name('ubahpasswordadmin');
});

Route::middleware('auth:member')->group(function () {
    Route::get('/materi-member', [MemberController::class, 'member'])->name('materi-member');
    Route::get('/pilih-materi/{id}', [MemberController::class, 'pilihmateri'])->name('pilihmateri');
    Route::post('/proses-pilihmateri', [MemberController::class, 'prosespilihmateri'])->name('prosespilihmateri');
    Route::post('/tambah-monitoring', [MemberController::class, 'tambahmonitoring'])->name('tambahmonitoring');
    Route::put('/update-monitoring/{id}', [MemberController::class, 'updatemonitoring'])->name('updatemonitoring');
    Route::get('/member-logaktivitas', [MemberController::class, 'logaktivitasmember'])->name('member-logaktivitas');
    Route::put('/tambahberatbadan', [MemberController::class, 'tambahberatbadan'])->name('tambahberatbadan');
    Route::put('/hitungberatbadan', [MemberController::class, 'hitungberatbadan'])->name('hitungberatbadan');
    Route::get('/lihat-materi/{logaktivitasid}', [MemberController::class, 'lihatmaterimember'])->name('lihatmaterimember');
    Route::get('/profil-member', [MemberController::class, 'profilmember'])->name('profilmember');
    Route::put('/profile-editmember', [MemberController::class, 'updatemember'])->name('updatemember');
    Route::post('/ubah-password-member', [AuthController::class, 'ubahpassword'])->name('ubahpasswordmember');
});

Route::middleware('auth:coach')->group(function () {
    Route::get('/materi-coach', [CoachController::class, 'coach'])->name('materi-coach');
    Route::get('laporan-materi/{tahun}/{bulan}/{materi}', [CoachController::class, 'cetakmatericoach'])->name('lapmatericoach');
    Route::get('/lihat-logaktivitas/{logaktivitasid}', [CoachController::class, 'lihatlogaktivitascoach'])->name('lihatlogaktivitascoach');
    Route::patch('/informasi-exercise/{id}', [CoachController::class, 'InformasiExercise'])->name('informasiexercise');
    Route::get('/profil-coach', [CoachController::class, 'profilcoach'])->name('profilcoach');
    Route::put('/profile-editcoach', [CoachController::class, 'updatecoach'])->name('updatecoach');
    Route::post('/ubah-password-coach', [AuthController::class, 'ubahpassword'])->name('ubahpasswordcoach');
});

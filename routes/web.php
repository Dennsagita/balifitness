<?php

use App\Models\Member;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\MemberController;

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
    Route::get('/', [AuthController::class, 'index'])->name('login'); //fungsi name = mengubah nama route 
    Route::post('login', [AuthController::class, 'proseslogin'])->name('proseslogin');
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
});

Route::middleware('auth:member')->group(function () {
    Route::get('/materi-member', [MemberController::class, 'member'])->name('materi-member');
});

Route::middleware('auth:coach')->group(function () {
    Route::get('/materi-coach', [CoachController::class, 'coach'])->name('materi-coach');
});

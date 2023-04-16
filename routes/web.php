<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\LelangController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MasyarakatController;


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

Route::get('/', [WelcomeController::class, 'index']);

Route::get('/authpetugas/login', [LoginController::class, 'userLogin'])->name('login');
Route::get('/logout', [LoginController::class, 'userLogout']);
Route::post('/authpetugas/login', [LoginController::class, 'logProses']);

Route::get('/register', [RegisterController::class, 'index']);
Route::post('/register/tambah/process', [RegisterController::class, 'tambah']);

Route::get('/masyarakat/login', [LoginController::class, 'masyarakatLogin'])->name('loginMasyarakat');
Route::get('/masyarakat/logout', [LoginController::class, 'masyarakatLogout']);
Route::post('/masyarakat/login', [LoginController::class, 'logProsess']);

Route::middleware('auth.masyarakat')->group(function() {
    Route::get('/masyarakat/dashboard', [MasyarakatController::class, 'indexPenawaran']);
    Route::get('/masyarakat/data/history', [LelangController::class, 'historyMasyarakat']);
    Route::get('/masyarakat/data/penawaran/{tb_lelang}', [MasyarakatController::class, 'detailPenawaran'] );
    Route::post('/masyarakat/penawaran/process/{tb_lelang}', [MasyarakatController::class, 'tambahPenawaran'] );
    Route::get('/detail/barang/{barang}/', [BarangController::class, 'indexWelcome']);
});

// # AUTH PETUGAS
Route::middleware('auth')->group(function () {
    // ADMIN //
    Route::get('admin/dashboard', [DashboardController::class, 'index']);
    Route::get('/admin/detail/penawaran/barang/{tb_lelang}', [DashboardController::class, 'detailPenawaran'] );
    // BARANG
    Route::get('/admin/data/barang', [BarangController::class, 'index']);
    Route::post('/admin/barang/tambah/process', [BarangController::class, 'tambah']);
    Route::post('/admin/barang/edit/{barang}', [BarangController::class, 'edit']);
    Route::get('/admin/barang/delete/{barang}', [BarangController::class, 'delete']);
    // # USERS (ADMIN, PETUGAS)
    Route::get('/admin/data/admin-petugas', [PetugasController::class, 'index']);
    Route::post('/admin/data/admin-petugas/tambah/process', [PetugasController::class, 'tambah']);
    Route::post('/admin/data/admin-petugas/edit/{petugas}', [PetugasController::class, 'edit']);
    Route::get('/admin/data/admin-petugas/delete/{petugas}', [PetugasController::class, 'delete']);
    // # MASYARAKAT
    Route::get('/admin/data/masyarakat', [MasyarakatController::class, 'index']);
    Route::post('/admin/data/masyarakat/tambah/process', [MasyarakatController::class, 'tambah'])->name('register');
    Route::post('/admin/data/masyarakat/edit/{masyarakat}', [MasyarakatController::class, 'edit']);
    Route::get('/admin/data/masyarakat/delete/{masyarakat}', [MasyarakatController::class, 'delete']);

    //  ===================== //
    // PETUGAS //
    Route::get('petugas/dashboard', [DashboardController::class, 'index']);
    // # BARANG
    Route::get('/petugas/data/barang', [BarangController::class, 'index']);
    Route::post('/petugas/barang/tambah/process', [BarangController::class, 'tambah']);
    Route::post('/petugas/barang/edit/{barang}', [BarangController::class, 'edit']);
    Route::get('/petugas/barang/delete/{barang}', [BarangController::class, 'delete']);
    // # LELANG
    Route::get('/petugas/data/lelang', [LelangController::class, 'index']);
    Route::post('/petugas/data/lelang/tambah/process', [LelangController::class, 'tambah']);
    Route::post('/petugas/data/lelang/edit/{tb_lelang}', [LelangController::class, 'edit']);
    Route::get('/petugas/data/lelang/edit-status/{status}/{tb_lelang}', [LelangController::class, 'editStatus']);
    Route::get('/petugas/data/lelang/delete/{tb_lelang}', [LelangController::class, 'delete']);
    // # HISTORY
    Route::get('/petugas/data/history/lelang/', [LelangController::class, 'history'] );
    Route::get('/petugas/detail/penawaran/barang/{tb_lelang}', [LelangController::class, 'detailPenawaran'] );

    // # PRINT
    Route::get('/exportpdf', [LelangController::class, 'exportpdf'])->name('exportpdf');
    Route::get('/exportexcel', [LelangController::class, 'exportexcel'])->name('exportexcel');
    Route::post('/importbarang', [BarangController::class, 'importbarang'])->name('importbarang');
}); // End Middleware Petugas
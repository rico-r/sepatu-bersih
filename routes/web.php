<?php

use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PelangganController;
use App\Models\Karyawan;
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

Route::post('/login', [LoginController::class, 'attempt'])->name('login.attempt');
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
// Route::get('/register', [PelangganController::class, 'registerCustomerForm'])->name('register');

Route::get('/', function() {
    return redirect(route('login'));
})->name('home');

Route::prefix('/karyawan')->as('karyawan.')->group(function() {
    Route::get('/', [KaryawanController::class, 'dashboard'])->name('dashboard');
    Route::get('/data', [KaryawanController::class, 'view'])->name('view');
    Route::get('/tambah', [KaryawanController::class, 'tambah'])->name('tambah');
    Route::get('/{karyawan}/edit', [KaryawanController::class, 'edit'])->name('edit');
    Route::post('/', [KaryawanController::class, 'store'])->name('store');
    Route::post('/{karyawan}/deactivate', [KaryawanController::class, 'deactivate'])->name('deactivate');
    Route::post('/{karyawan}/activate', [KaryawanController::class, 'activate'])->name('activate');
    Route::post('/{karyawan}', [KaryawanController::class, 'update'])->name('update');
});

Route::prefix('/layanan')->as('layanan.')->group(function() {
    Route::get('/', [LayananController::class, 'view'])->name('view');
    Route::get('/tambah', [LayananController::class, 'tambah'])->name('tambah');
    Route::get('/{layanan}/edit', [LayananController::class, 'edit'])->name('edit');
    Route::post('/{layanan}', [LayananController::class, 'update'])->name('update');
    Route::delete('/{layanan}', [LayananController::class, 'delete'])->name('delete');
    Route::post('/', [LayananController::class, 'store'])->name('store');
});


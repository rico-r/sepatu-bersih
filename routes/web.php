<?php

use App\Http\Controllers\KaryawanController;
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

Route::get('/karyawan', [KaryawanController::class, 'dashboard'])->name('karyawan.dashboard');
Route::get('/karyawan/data', [KaryawanController::class, 'view'])->name('karyawan.view');
Route::get('/karyawan/tambah', [KaryawanController::class, 'tambah'])->name('karyawan.tambah');
Route::post('/karyawan', [KaryawanController::class, 'store'])->name('karyawan.store');
Route::get('/karyawan/{karyawan}/edit', [KaryawanController::class, 'edit'])->name('karyawan.edit');
Route::post('/karyawan/{karyawan}/deactivate', [KaryawanController::class, 'deactivate'])->name('karyawan.deactivate');
Route::post('/karyawan/{karyawan}/activate', [KaryawanController::class, 'activate'])->name('karyawan.activate');
Route::post('/karyawan/{karyawan}', [KaryawanController::class, 'update'])->name('karyawan.update');

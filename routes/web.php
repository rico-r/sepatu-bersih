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

Route::view('/', 'welcome')->name('home');

Route::post('/login', [LoginController::class, 'attempt']);
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
// Route::get('/register', [PelangganController::class, 'registerCustomerForm'])->name('register');

Route::get('/karyawan', [KaryawanController::class, 'dashboard'])->name('karyawan.dashboard');
Route::get('/karyawan/data', [KaryawanController::class, 'viewDataKaryawan'])->name('karyawan.data');

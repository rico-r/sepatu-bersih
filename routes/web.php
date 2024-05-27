<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
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

Route::get('/', function () {
    return redirect(route('login'));
})->name('home');

Route::prefix('/stat')->group(function () {
    Route::post('/month-revenue', [DashboardController::class, 'getMonthRevenue']);
    Route::post('/service-type', [DashboardController::class, 'getServiceTypeCount']);
    Route::post('/report', [DashboardController::class, 'getReportContent']);
});

Route::prefix('/admin')->as('admin.')->middleware('can:manage-web')->group(function () {
    Route::get('/dashboard', [KaryawanController::class, 'dashboard'])->name('dashboard');
});

Route::prefix('/karyawan')->as('karyawan.')->group(function () {
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::get('/redirect', [ProfileController::class, 'redirect'])->name('dashboard');
    Route::post('/profile', [ProfileController::class, 'updateProfile'])->name('update-profile');

    Route::get('/data', [KaryawanController::class, 'view'])->name('view');
    Route::get('/tambah', [KaryawanController::class, 'tambah'])->name('tambah');
    Route::get('/{karyawan}/edit', [KaryawanController::class, 'edit'])->name('edit');
    Route::post('/', [KaryawanController::class, 'store'])->name('store');
    Route::post('/{karyawan}/deactivate', [KaryawanController::class, 'deactivate'])->name('deactivate');
    Route::post('/{karyawan}/activate', [KaryawanController::class, 'activate'])->name('activate');
    Route::post('/{karyawan}', [KaryawanController::class, 'update'])->name('update');
});

Route::prefix('/layanan')->as('layanan.')->group(function () {
    Route::get('/', [LayananController::class, 'view'])->name('view');
    Route::get('/tambah', [LayananController::class, 'tambah'])->name('tambah');
    Route::get('/{layanan}/edit', [LayananController::class, 'edit'])->name('edit');
    Route::post('/{layanan}', [LayananController::class, 'update'])->name('update');
    Route::delete('/{layanan}', [LayananController::class, 'delete'])->name('delete');
    Route::post('/', [LayananController::class, 'store'])->name('store');
});

Route::prefix('/pesanan')->as('order.')->group(function () {
    Route::get('/', [OrderController::class, 'all'])->name('all');
    Route::get('/buat', [OrderController::class, 'makeOrderView'])->name('make');
    Route::get('/diproses', [OrderController::class, 'listProcess'])->name('process');
    Route::get('/selesai', [OrderController::class, 'listReady'])->name('ready');
    Route::get('/diambil', [OrderController::class, 'listDone'])->name('done');
    Route::get('/{pesanan}', [OrderController::class, 'view'])->name('view');
    Route::get('/{pesanan}/json', [OrderController::class, 'getJson']);
    Route::get('/{pesanan}/delete', [OrderController::class, 'delete'])->name('delete');
    Route::post('/{pesanan}/mark-process', [OrderController::class, 'markProcess'])->name('mark-process');
    Route::post('/{pesanan}/mark-ready', [OrderController::class, 'markReady'])->name('mark-ready');
    Route::post('/{pesanan}/mark-done', [OrderController::class, 'markDone'])->name('mark-done');
    Route::post('/{pesanan}/revert-ready', [OrderController::class, 'revertReady'])->name('revert-ready');
    Route::post('/{pesanan}/revert-done', [OrderController::class, 'revertDone'])->name('revert-done');
    Route::post('/simpan', [OrderController::class, 'saveOrder'])->name('save');
});

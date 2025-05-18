<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\SupirController;
use App\Http\Controllers\LogKendaraanController;

/* Route::get('/', function () {
    return view('welcome');
}); */

/* Route::get('/', function () {
    return view('dashboard');
}); */

Route::get('/', [KendaraanController::class, 'dashboard'])->name('dashboard');

// Menampilkan daftar kendaraan
Route::get('/kendaraan/list', [KendaraanController::class, 'index'])->name('kendaraan.index');

// Menampilkan form tambah kendaraan
Route::get('/kendaraan/create', [KendaraanController::class, 'create'])->name('kendaraan.create');

// Menyimpan data dari form
Route::post('/kendaraan', [KendaraanController::class, 'store'])->name('kendaraan.store');

// Tampilkan form edit kendaraan
Route::get('/kendaraan/{id}/edit', [KendaraanController::class, 'edit'])->name('kendaraan.edit');

// Simpan perubahan data kendaraan
Route::put('/kendaraan/{id}', [KendaraanController::class, 'update'])->name('kendaraan.update');

// Softdelete kendaraan
Route::delete('/kendaraan/{id}/softdelete', [KendaraanController::class, 'softdelete'])->name('kendaraan.softdelete');

//  Untuk load dengan WS
Route::get('/kendaraan/card', [KendaraanController::class, 'card'])->name('kendaraan.card');

// Menampilkan daftar driver
Route::get('/driver/list', [SupirController::class, 'index'])->name('supir.index');

// Menampilkan form tambah driver
Route::get('/driver/create', [SupirController::class, 'create'])->name('supir.create');

// Menyimpan data dari form
Route::post('/driver', [SupirController::class, 'store'])->name('supir.store');

// Tampilkan form edit driver
Route::get('/driver/{id}/edit', [SupirController::class, 'edit'])->name('supir.edit');

// Simpan perubahan data driver
Route::put('/driver/{id}', [SupirController::class, 'update'])->name('supir.update');

// Softdelete driver
Route::delete('/driver/{id}/softdelete', [SupirController::class, 'softdelete'])->name('supir.softdelete');

// Menyimpan data dari form
Route::post('/log-kendaraan/{id}', [LogKendaraanController::class, 'store'])->name('log_kendaraan.store');

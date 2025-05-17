<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KendaraanController;

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

//  Untuk load dengan HTMX
Route::get('/kendaraan/card', [KendaraanController::class, 'card'])->name('kendaraan.card');

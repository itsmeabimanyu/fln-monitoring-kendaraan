<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{
    public function dashboard()
    {
        $title = 'Dashboard';
        $kendaraans = Kendaraan::all();
        return view('dashboard', compact('kendaraans', 'title'));
    }

    // Menampilkan form untuk menambah data kendaraan
    public function create()
    {
        $title = 'Registrasi Kendaraan';
        // Tampilkan view form tambah kendaraan
        return view('kendaraan.create', compact('title'));
    }

    // Menyimpan data kendaraan yang dikirim dari form
    public function store(Request $request)
    {
        // Validasi data yang dikirim dari form
        $validated = $request->validate([
            'nama_mobil' => 'required', // wajib diisi
            'nopol' => 'required',      // wajib diisi
            'status' => 'required|in:standby,pergi,perbaikan', // hanya boleh salah satu dari tiga nilai ini
        ]);

        // Simpan data kendaraan ke database menggunakan mass assignment
        Kendaraan::create($validated);

        // Redirect ke halaman daftar kendaraan + kirim pesan sukses
        return redirect('/kendaraan')->with('success', 'Kendaraan berhasil ditambahkan!');

        // Redirect kembali ke halaman create dengan pesan sukses
        // return redirect()->back()->with('success', 'Kendaraan berhasil ditambahkan!');
    }


    // Menampilkan daftar seluruh kendaraan
    public function index()
    {
        // Ambil semua data kendaraan dari database
        $kendaraans = Kendaraan::all();
        $title = 'List Kendaraan';

        // Tampilkan ke view resources/views/kendaraan/index.blade.php
        return view('kendaraan.index', compact('kendaraans', 'title'));
    }
    
    public function edit($id)
    {
        // Cari kendaraan berdasarkan ID, kalau tidak ketemu akan error 404 otomatis
        $title = 'Edit Kendaraan';
        $kendaraan = Kendaraan::findOrFail($id);

        // Tampilkan form edit dengan data kendaraan
        return view('kendaraan.edit', compact('kendaraan', 'title'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_mobil' => 'required',
            'nopol' => 'required',
            'status' => 'required|in:standby,pergi,perbaikan',
        ]);

        // Cari kendaraan dan update datanya
        $kendaraan = Kendaraan::findOrFail($id);
        $kendaraan->update($validated);

        // Redirect ke list kendaraan dengan pesan sukses
        return redirect('/kendaraan')->with('success', 'Kendaraan berhasil diperbarui!');
        // return view('kendaraan.index')->with('success', 'Kendaraan berhasil diperbarui!');
    }

    //  Untuk load dengan HTMX
    public function card()
    {
        $kendaraans = Kendaraan::all();
        return view('kendaraan._card', compact('kendaraans'));
    }
}

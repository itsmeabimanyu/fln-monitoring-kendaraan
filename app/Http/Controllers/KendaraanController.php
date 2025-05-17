<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = 'kendaraan_' . time() . '.jpg';
        
            $manager = new ImageManager(new Driver()); // Gunakan GD atau Imagick
            $processedImage = $manager->read($image->getPathname())
                ->cover(800, 600) // Crop ke rasio 4:3 (800x600)
                ->toJpeg(80); // Simpan ke JPEG dengan kualitas 80%
        
            Storage::disk('public')->put('kendaraan/' . $filename, $processedImage);
        
            $validated['image'] = 'kendaraan/' . $filename;
        }

        // Simpan data kendaraan ke database menggunakan mass assignment
        Kendaraan::create($validated);

        // Redirect ke halaman daftar kendaraan + kirim pesan sukses
        return redirect('/kendaraan/list')->with('success', 'Kendaraan berhasil ditambahkan!');

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Cari kendaraan dan update datanya
        $kendaraan = Kendaraan::findOrFail($id);

        // Handle image upload
        if ($request->hasFile('image')) {
            if ($kendaraan->image) {
                Storage::disk('public')->delete($kendaraan->image);
            }
    
            $manager = new ImageManager(new Driver());
            $image = $manager->read($request->file('image')->getPathname());
    
            // Crop dan resize ke 4:3, ukuran 800x600
            $image->cover(800, 600);
    
            $encoded = $image->toJpeg(80);
            $filename = 'kendaraan_' . time() . '.jpg';
    
            Storage::disk('public')->put('kendaraan/' . $filename, $encoded);
    
            $validated['image'] = 'kendaraan/' . $filename;
        }

        $kendaraan->update($validated);

        // Redirect ke list kendaraan dengan pesan sukses
        return redirect('/kendaraan/list')->with('success', 'Kendaraan berhasil diperbarui!');
        // return view('kendaraan.index')->with('success', 'Kendaraan berhasil diperbarui!');
    }

    //  Untuk load dengan HTMX
    public function card()
    {
        $kendaraans = Kendaraan::all();
        return view('kendaraan._card', compact('kendaraans'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogKendaraan;

class LogKendaraanController extends Controller
{
    // Menyimpan data log yang dikirim dari form
    public function store(Request $request, $id)
    {
        // Validasi data yang dikirim dari form
        $validated = $request->validate([
            'supir_id'     => 'nullable|exists:supirs,id',
            'tujuan'       => 'nullable|string|max:255',
            'keterangan'   => 'nullable|string',
            'penumpang'    => 'nullable|string|max:255',
            'status'       => 'required|in:standby,pergi,perbaikan',
        ]);

        // Simpan kendaraan_id dari route parameter
        $validated['kendaraan_id'] = $id;
        $validated['supir_id'] = $request->supir_id ?: null;

        LogKendaraan::create($validated);

        // Redirect ke halaman dashboard + kirim pesan sukses
        return redirect()->route('dashboard')->with('success', 'Log kendaraan berhasil ditambahkan.');
    }
}

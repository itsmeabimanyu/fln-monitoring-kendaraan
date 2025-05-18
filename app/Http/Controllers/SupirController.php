<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supir;

class SupirController extends Controller
{
    // Menampilkan daftar seluruh supir
    public function index()
    {
        $list_item = Supir::where('is_active', true)->get();

        foreach ($list_item as $item) {
            $item->kehadiran ='<span class="badge rounded-pill border ' . 
                                ($item->status_hadir === 'hadir' ? 'bg-success-subtle text-success border-success' : 'bg-danger-subtle text-danger border-danger') . '">' . ucfirst($item->status_hadir) . 
                            '</span>';
            $urlUpdate = route('supir.edit', ['id' => $item->id]);
            $item->buttons_action = "
                <button type='button' class='btn btn-sm btn-warning' onclick='window.location.href=\"$urlUpdate\"'>
                    Update
                </button>
                <button type='button' class='btn btn-sm btn-danger'
                      data-bs-toggle='modal' data-bs-target='#delete-modal-$item->id'>
                    Hapus
                </button>
            ";

            // Content modal
            $item->modals_form = [
                'Hapus Driver' => [
                    'modal_id' => 'confirm-' . $item->id,
                    'description' => '<p>Anda akan menonaktifkan driver <strong>' . $item . '</strong>.
                    Data ini tidak akan dihapus secara permanen, namun tidak akan muncul dalam daftar aktif.
                    Anda tetap dapat memulihkannya di kemudian hari melalui halaman arsip atau restore.</p>
                    <p>Apakah Anda yakin ingin melanjutkan proses ini?</p>',
                    'action_url' => route('supir.softdelete', ['id' => $item->id]),
                ],
            ];            
        }
        
        $title = 'List Driver';
        $fields = [
            'nama' => 'Nama Driver',
            'telepon' => 'No. Telepon',
            'kehadiran' => 'Status Hadir',
            'buttons_action' => 'Actions',
        ];

        $additional_button = "<button type='button' class='btn btn-primary mb-3' onclick='window.location.href=\"" . route('supir.create') . "\"'><i class='ti ti-plus'></i> Driver</button>";
        return view('kendaraan.index', compact('list_item', 'fields', 'title', 'additional_button'));
    }

    // Menampilkan form untuk menambah data driver
    public function create()
    {
        $title = 'Registrasi Driver';
        $formFields = [
            ['name' => 'nama', 'label' => 'Nama Driver', 'type' => 'text', 'value' => old('nama')],
            ['name' => 'telepon', 'label' => 'No. Telepon', 'type' => 'text', 'value' => old('telepon')],
        ];
        $action = route('supir.store');
        // Tampilkan view form tambah driver
        return view('kendaraan.create', compact('title', 'formFields', 'action'));
    }

    // Menyimpan data driver yang dikirim dari form
    public function store(Request $request)
    {
        // Validasi data yang dikirim dari form
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:20',
        ]);

        // Simpan data driver ke database menggunakan mass assignment
        Supir::create($validated);

        // Redirect ke halaman daftar driver + kirim pesan sukses
        return redirect()->route('supir.index')->with('success', 'Driver berhasil ditambahkan!');
    }

    public function edit($id)
    {
        // Cari driver berdasarkan ID, kalau tidak ketemu akan error 404 otomatis
        $title = 'Edit Driver';
        $item = Supir::findOrFail($id);
        $formFields = [
            ['name' => 'nama', 'label' => 'Nama Driver', 'type' => 'text', 'value' => old('nama_mobil', $item->nama)],
            ['name' => 'telepon', 'label' => 'No. Telepon', 'type' => 'text', 'value' => old('nopol', $item->telepon)],
            ['name' => 'status_hadir', 'label' => 'Status Kehadiran', 'type' => 'select', 
                'value' => old('status_hadir', $item->status_hadir ?? ''),
                'options' => [
                    'hadir' => 'Hadir',
                    'absen' => 'Absen',
                ],
            ],
        ];

        $action = route('supir.update', $item->id);

        // Tampilkan form dengan data driver
        return view('kendaraan.create', compact('title', 'formFields', 'action', 'item'));
    }

    public function update(Request $request, $id)
    {
        // Cari driver dan update datanya
        $driver = Supir::findOrFail($id);

        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'status_hadir' => 'required|in:hadir,absen',
        ]);

        $driver->update($validated);

        // Redirect ke list driver dengan pesan sukses
        return redirect()->route('supir.index')->with('success', 'Driver berhasil diperbarui!');
    }

    public function softdelete($id)
    {
        $driver = Supir::findOrFail($id);
        $driver->is_active = false;
        $driver->save();

        return redirect()->route('supir.index')->with('success', 'Driver berhasil dihapus.');
    }
}

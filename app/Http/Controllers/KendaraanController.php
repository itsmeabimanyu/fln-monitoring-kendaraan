<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kendaraan;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Supir;

class KendaraanController extends Controller
{
    public function dashboard()
    {
        $title = 'Dashboard';
        $list_item = Kendaraan::where('is_active', true)
            ->orderBy('status', 'asc')
            ->get();

        foreach ($list_item as $item) {
            $item->new_status = '<span class="badge rounded-pill border ' . 
                            ($item->status === 'standby' ? 'bg-success-subtle text-success border-success' : 
                            ($item->status === 'pergi' ? 'bg-indigo-subtle text-indigo border-indigo' : 'bg-danger-subtle text-danger border-danger')) . '">' . ucfirst($item->status) . 
                        '</span>';

            $item->modals_form = [
                (string) $item => [
                    'modal_id' => '',
                    'description' => '',
                    'action_url' => route('log_kendaraan.store', ['id' => $item->id]),
                ],
            ];
        }

        $supirs = Supir::where('is_active', true)
               ->where('status_hadir', 'hadir')
               ->get();

        $formFields = [
            [
                'name' => 'status',
                'label' => 'Status Kendaraan',
                'type' => 'select',
                'value' => old('status'),
                'options' => [
                    'standby' => 'Standby',
                    'pergi' => 'Pergi',
                    'perbaikan' => 'Perbaikan',
                ],
            ],

            [
                'name' => 'supir_id', 'label' => 'Pilih Driver', 'type' => 'select', 
                'value' => old('supir_id', $item->supir_id ?? ''),
                'options' => $supirs->pluck('nama', 'id')->toArray() + ['' => 'Lainnya'],
            ],

            [
                'name' => 'penumpang',
                'label' => 'Penumpang',
                'type' => 'text',
                'value' => old('penumpang'),
            ],

            [
                'name' => 'tujuan',
                'label' => 'Tempat Tujuan',
                'type' => 'text',
                'value' => old('tujuan'),
            ],

            [
                'name' => 'keterangan',
                'label' => 'Keterangan',
                'type' => 'textarea',
                'value' => old('keterangan'),
            ],

        ];        

        return view('dashboard', compact('list_item', 'title', 'formFields'));
    }

    // Menampilkan form untuk menambah data kendaraan
    public function create()
    {
        $title = 'Registrasi Kendaraan';
        $formFields = [
            ['name' => 'nama_mobil', 'label' => 'Nama Kendaraan', 'type' => 'text', 'value' => old('nama_mobil')],
            ['name' => 'nopol', 'label' => 'No Polisi', 'type' => 'text', 'value' => old('nopol')],
            ['name' => 'status', 'label' => 'Status Kendaraan', 'type' => 'select', 
                'value' => old('status'),
                'options' => [
                    'standby' => 'Standby',
                    'pergi' => 'Pergi',
                    'perbaikan' => 'Perbaikan',
                ],
            ],
            ['name' => 'image', 'label' => 'Gambar', 'type' => 'file', 'value' => '', 'attributes' => ['accept' => 'image/*']],
        ];
        $action = route('kendaraan.store');
        // Tampilkan view form tambah kendaraan
        return view('kendaraan.create', compact('title', 'formFields', 'action'));
    }

    // Menyimpan data kendaraan yang dikirim dari form
    public function store(Request $request)
    {
        // Validasi data yang dikirim dari form
        $validated = $request->validate([
            'nama_mobil' => 'required',
            'nopol' => 'required|unique:kendaraans,nopol',
            'status' => 'required|in:standby,pergi,perbaikan', // hanya boleh salah satu dari tiga nilai ini
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'nopol.unique' => 'Nomor polisi sudah terdaftar. Silakan gunakan yang lain.',
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
        return redirect()->route('kendaraan.index')->with('success', 'Kendaraan berhasil ditambahkan!');

        // Redirect kembali ke halaman create dengan pesan sukses
        // return redirect()->back()->with('success', 'Kendaraan berhasil ditambahkan!');
    }

    // Menampilkan daftar seluruh kendaraan
    public function index()
    {
        $list_item = Kendaraan::where('is_active', true)->get();

        foreach ($list_item as $item) {
            $item->new_status = '<span class="badge rounded-pill border ' . 
                            ($item->status === 'standby' ? 'bg-success-subtle text-success border-success' : 
                            ($item->status === 'pergi' ? 'bg-indigo-subtle text-indigo border-indigo' : 'bg-danger-subtle text-danger border-danger')) . '">' . ucfirst($item->status) . 
                        '</span>';
            $item->gambar = $item->image
                ? '<img src="' . asset('storage/' . $item->image) . '" class="img-thumbnail" style="width:100px;" alt="Gambar Kendaraan" />'
                : '<img src="' . asset('assets/images/placeholder.jpg') . '" class="img-thumbnail" style="width:100px;" alt="Gambar Kendaraan" />';

            $urlUpdate = route('kendaraan.edit', ['id' => $item->id]);
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
                'Hapus Kendaraan' => [
                    'modal_id' => 'confirm-' . $item->id,
                    'description' => '<p>Anda akan menonaktifkan kendaraan <strong>' . $item . '</strong>.
                    Data ini tidak akan dihapus secara permanen, namun tidak akan muncul dalam daftar aktif.
                    Anda tetap dapat memulihkannya di kemudian hari melalui halaman arsip atau restore.</p>
                    <p>Apakah Anda yakin ingin melanjutkan proses ini?</p>',
                    'action_url' => route('kendaraan.softdelete', ['id' => $item->id]),
                ],
            ];            
        }
        
        $title = 'List Kendaraan';
        $fields = [
            'gambar' => 'Gambar Kendaraan',
            'nama_mobil'   => 'Nama Kendaraan',
            'nopol'  => 'No Polisi',
            'new_status' => 'Status Kendaraan',
            'buttons_action' => 'Actions',
        ];

        $additional_button = "<button type='button' class='btn btn-primary mb-3' onclick='window.location.href=\"" . route('kendaraan.create') . "\"'><i class='ti ti-plus'></i> Kendaraan</button>";

        return view('kendaraan.index', compact('list_item', 'fields', 'title', 'additional_button'));
    }
    
    public function edit($id)
    {
        // Cari kendaraan berdasarkan ID, kalau tidak ketemu akan error 404 otomatis
        $title = 'Edit Kendaraan';
        $item = Kendaraan::findOrFail($id);
        $formFields = [
            ['name' => 'nama_mobil', 'label' => 'Nama Kendaraan', 'type' => 'text', 'value' => old('nama_mobil', $item->nama_mobil)],
            ['name' => 'nopol', 'label' => 'No Polisi', 'type' => 'text', 'value' => old('nopol', $item->nopol)],
            ['name' => 'status', 'label' => 'Status Kendaraan', 'type' => 'select', 
                'value' => old('status', $item->status ?? ''),
                'options' => [
                    'standby' => 'Standby',
                    'pergi' => 'Pergi',
                    'perbaikan' => 'Perbaikan',
                ],
            ],
            ['name' => 'image', 'label' => 'Gambar', 'type' => 'file', 'value' => '', 'attributes' => ['accept' => 'image/*']],
        ];

        $action = route('kendaraan.update', $item->id);

        // Tampilkan form dengan data kendaraan
        return view('kendaraan.create', compact('title', 'formFields', 'action', 'item'));
    }

    public function update(Request $request, $id)
    {
        // Cari kendaraan dan update datanya
        $kendaraan = Kendaraan::findOrFail($id);

        // Validasi input
        $validated = $request->validate([
            'nama_mobil' => 'required',
            'nopol' => 'required|unique:kendaraans,nopol,' . $kendaraan->id,
            'status' => 'required|in:standby,pergi,perbaikan',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'nopol.unique' => 'Nomor polisi sudah terdaftar. Silakan gunakan yang lain.',
        ]);

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
        return redirect()->route('kendaraan.index')->with('success', 'Kendaraan berhasil diperbarui!');
        // return view('kendaraan.index')->with('success', 'Kendaraan berhasil diperbarui!');
    }

    public function softdelete($id)
    {
        $kendaraan = Kendaraan::findOrFail($id);
        $kendaraan->is_active = false; // anggap kamu pakai field boolean is_active
        $kendaraan->save();

        return redirect()->route('kendaraan.index')->with('success', 'Kendaraan berhasil dihapus.');
    }

    //  Untuk load dengan HTMX
    public function card()
    {
        $list_item = Kendaraan::where('is_active', true)
            ->orderBy('status', 'asc')
            ->get();

        foreach ($list_item as $item) {
            $item->new_status = '<span class="badge rounded-pill border ' . 
                            ($item->status === 'standby' ? 'bg-success-subtle text-success border-success' : 
                            ($item->status === 'pergi' ? 'bg-indigo-subtle text-indigo border-indigo' : 'bg-danger-subtle text-danger border-danger')) . '">' . ucfirst($item->status) . 
                        '</span>';
        }

        return view('kendaraan._card', compact('list_item'));
    }
}

@extends('layouts.app')
@section('page_title', 'Tambah Kendaraan')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="mb-3">
            <h5 class="mb-0">{{ $title }}</h5>
        </div>
        <form action="{{ route('kendaraan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="p-3">
                <label for="nama_mobil" class="form-label">Nama Mobil</label>
                <input type="text" class="form-control" name="nama_mobil" required>
            </div>
            
            <div class="p-3">
                <label for="nopol" class="form-label">Nomor Polisi</label>
                <input type="text" class="form-control" name="nopol" required>
            </div>
            
            <div class="p-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control form-select w-50" name="status" required>
                  <option value="standby">Standby</option>
                  <option value="pergi">Pergi</option>
                  <option value="perbaikan">Perbaikan</option>
                </select>
            </div>

            <div class="p-3">
                <label for="image" class="form-label">Gambar Kendaraan</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                @error('image')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="p-3">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@extends('layouts.app')
@section('page_title', 'Edit Kendaraan')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="mb-3">
            <h5 class="mb-0">{{ $title }}</h5>
        </div>
        <form action="{{ route('kendaraan.update', $kendaraan->id) }}" method="POST">
            @csrf
            @method('PUT') {{-- Ini penting untuk method PUT --}}
        
            <div class="mb-3">
                <label for="nama_mobil" class="form-label">Nama Mobil</label>
                <input type="text" name="nama_mobil" id="nama_mobil" class="form-control" value="{{ old('nama_mobil', $kendaraan->nama_mobil) }}">
                @error('nama_mobil')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
        
            <div class="mb-3">
                <label for="nopol" class="form-label">No. Polisi</label>
                <input type="text" name="nopol" id="nopol" class="form-control" value="{{ old('nopol', $kendaraan->nopol) }}">
                @error('nopol')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
        
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select">
                    @foreach(['standby', 'pergi', 'perbaikan'] as $status)
                        <option value="{{ $status }}" {{ old('status', $kendaraan->status) == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
                @error('status')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
        
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ url('/kendaraan') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection

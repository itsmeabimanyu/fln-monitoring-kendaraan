@extends('layouts.app')
@section('page_title', 'Daftar Kendaraan')

@section('content')
    <a href="/kendaraan/create" class="btn btn-primary mb-3">Tambah Kendaraan</a>
    <div class="datatables">
        <!-- alternative pagination -->
        <div class="row">
            <div class="col-12">
            <!-- start Alternative Pagination -->
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <h5 class="mb-0">{{ $title }}</h5>
                    </div>

                    <div class="table-responsive">
                        <table id="alt_pagination" class="table border table-hover table-striped table-bordered display text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Gambar</th>
                                    <th>Nama Mobil</th>
                                    <th>No. Polisi</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kendaraans as $kendaraan)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><img class="img-thumbnail" 
                                        src="@if($kendaraan->image){{ asset('storage/'.$kendaraan->image) }}@else{{ asset('assets/images/placeholder.jpg') }}@endif" 
                                        alt="Gambar Kendaraan {{ $kendaraan->nama_mobil }}">
                                    </td>
                                    <td>{{ $kendaraan->nama_mobil }}</td>
                                    <td>{{ $kendaraan->nopol }}</td>
                                    <td>{{ $kendaraan->status }}</td>
                                    <td>
                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('kendaraan.edit', $kendaraan->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
            <!-- end Alternative Pagination -->
            </div>
        </div>
    </div>
@endsection

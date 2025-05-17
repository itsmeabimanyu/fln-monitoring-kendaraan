
@foreach ($kendaraans as $kendaraan)
    <div class="col-md-3 mb-3">
        <div class="card h-100 d-flex flex-column">
            <img class="card-img-top img-responsive p-2" 
                src="@if($kendaraan->image){{ asset('storage/'.$kendaraan->image) }}@else{{ asset('assets/images/placeholder.jpg') }}@endif" 
                alt="Gambar Kendaraan {{ $kendaraan->nama_mobil }}">
            <div class="card-body">
                <div class="d-flex no-block align-items-center mb-3">
                <span class="d-flex align-items-center"><i class="ti ti-calendar me-1 fs-5"></i> 19 May
                    2023</span>
                <!-- <div class="ms-auto">
                    <a href="javascript:void(0)" class="link text-muted"><i class="ti ti-message-circle me-1 fs-5"></i> 16 Comments</a>
                </div> -->
                </div>
                <h3 class="fs-6">
                    {{ $kendaraan->nama_mobil }}
                </h3>
                <h5 class="fw-bold fs-3">
                   {{ $kendaraan->nopol }}
                </h5>
                <p class="mb-0 mt-2 text-muted">
                {{ $kendaraan->status }}
                </p>
                <div class="text-end">
                <button class="btn btn-primary rounded-pill mt-3">
                    Read more
                </button>
                </div>
            </div>
            </div>
    </div>
@endforeach

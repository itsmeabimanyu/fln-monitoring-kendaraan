
@foreach ($kendaraans as $kendaraan)
    <div class="col-md-4 mb-4">
        <div class="card">
            <img class="card-img-top img-responsive" src="../assets/images/blog/blog-img6.jpg" alt="Card image cap">
            <div class="card-body">
                <div class="d-flex no-block align-items-center mb-3">
                <span class="d-flex align-items-center"><i class="ti ti-calendar me-1 fs-5"></i> 19 May
                    2023</span>
                <!-- <div class="ms-auto">
                    <a href="javascript:void(0)" class="link text-muted"><i class="ti ti-message-circle me-1 fs-5"></i> 16 Comments</a>
                </div> -->
                </div>
                <h3 class="fs-6">
                {{ $kendaraan->nama_mobil }} ({{ $kendaraan->nopol }}  )
                </h3>
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

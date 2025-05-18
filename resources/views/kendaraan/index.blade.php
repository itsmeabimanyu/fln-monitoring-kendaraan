@extends('layouts.app')
@section('page_title', 'Daftar Kendaraan')

@section('content')
    {!! $additional_button !!}
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
                                    @foreach ($fields as $key => $label)
                                        <th>{{ $label }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list_item as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        @foreach ($fields as $key => $label)
                                        <td>{!! data_get($item, $key) !!}</td>
                                        @endforeach
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

    @foreach ($list_item as $item)
        @foreach ($item->modals_form as $modal_title => $modal_data)
        <!-- Modal Delete -->
        <div id="delete-modal-{{ $item->id }}" class="modal fade" tabindex="-1" aria-labelledby="delete-modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <form action="{{ $modal_data['action_url'] }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <div class="modal-header modal-colored-header bg-danger text-white">
                            <h4 class="modal-title text-white" id="delete-modalLabel">
                                {{ $modal_title }}
                            </h4>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h5 class="mt-0">{{ $item }}</h5>
                                {!! $modal_data['description'] !!}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">
                                Tutup
                            </button>
                            <button type="submit" class="btn btn-sm btn-danger ">
                                Lanjutkan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    @endforeach
@endsection

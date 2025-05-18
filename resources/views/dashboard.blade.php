@extends('layouts.app')
@section('page_title', 'Dashboard')

@section('content')
    {{-- <div class="row" id="dynamic-card" hx-get="{{ route('kendaraan.card') }}" hx-trigger="load, every 5s">
    @include('kendaraan._card')
    </div> --}}

    <div class="row" id="dynamic-card">
        @include('kendaraan._card')
    </div>

    @include('kendaraan._modal_form')

    <script>
        // 2. Inisialisasi Laravel Echo
        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: '{{ env("REVERB_APP_KEY") }}',
            wsHost: window.location.hostname,
            wsPort: 8080, // default port Reverb = 6001
            forceTLS: false,
            disableStats: true,
            enabledTransports: ['ws'],
        });
    
        // 3. Cek koneksi WebSocket
        Echo.connector.pusher.connection.bind('connected', () => {
            console.log('🔌 WebSocket Connected');
        });

        Pusher.logToConsole = true;
    
        // 4. Dengarkan Event
        Echo.channel('public-channel')
        .listen('.data.changed', (e) => {
            console.log('🎯 Event diterima:', e);

            fetch('{{ route('kendaraan.card') }}')
                .then(response => response.text())
                .then(updatedHtml => {
                    const target = document.getElementById('dynamic-card');
                    if (target) {
                        target.innerHTML = updatedHtml;
                    }
                })
                .catch(error => {
                    console.error('Gagal memuat data kendaraan:', error);
                });
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function () {
        $('.modal-body .form-group').not(':has(#status)').hide();

        $('.form-select').on('change', function () {
            const selectedValue = $(this).val();
            if (selectedValue === 'pergi') {
                $('.modal-body .form-group').show();
                // Jadikan required semua input, textarea, dan select kecuali #status sendiri
                $('.modal-body .form-group').not(':has(#status)').find('input, textarea').attr('required', true);
            } else {
                // Sembunyikan semua kecuali yang punya #status
                $('.modal-body .form-group').not(':has(#status)').hide();
                // Kosongkan nilai dan hilangkan required pada input, textarea, dan select di form-group yang disembunyikan
                $('.modal-body .form-group').not(':has(#status)').find('input, textarea').val('').removeAttr('required');
            }
        });
    });
    </script>

@endsection

@extends('layouts.app')
@section('page_title', 'Dashboard')

@section('content')
    {{-- <div class="row" id="dynamic-card" hx-get="{{ route('kendaraan.card') }}" hx-trigger="load, every 5s">
    @include('kendaraan._card')
    </div> --}}

    <div class="row" id="dynamic-card">
        @include('kendaraan._card')
    </div>

    <div id="messages"></div>

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
@endsection

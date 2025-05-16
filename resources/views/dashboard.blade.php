@extends('layouts.app')
@section('page_title', 'Dashboard')

@section('content')
    <div class="row" id="dynamic-card" hx-get="{{ route('kendaraan.card') }}" hx-trigger="load, every 5s">
    @include('kendaraan._card')
    </div>
@endsection

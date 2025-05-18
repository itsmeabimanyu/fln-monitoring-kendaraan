@extends('layouts.app')
@section('page_title', 'Tambah Kendaraan')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="mb-3">
            <h5 class="mb-0">{{ $title }}</h5>
        </div>

        @if (isset($item))
            @if($item->image)
                <div class="mt-3 mb-3">
                    <img src="{{ asset('storage/'.$item->image) }}" alt="Gambar Kendaraan" width="150" class="img-thumbnail">
                </div>
            @endif
        @endif

        <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($item))
                @method('PUT')
            @endif
        
            @foreach ($formFields as $field)
                <div class="form-group mb-3">
                    <label for="{{ $field['name'] }}" class="mb-2">{{ $field['label'] }}</label>
        
                    @if ($field['type'] === 'text')
                        <input type="text" 
                               name="{{ $field['name'] }}" 
                               id="{{ $field['name'] }}" 
                               value="{{ $field['value'] }}" 
                               class="form-control">
                    @elseif ($field['type'] === 'file')
                        <input type="file" 
                               name="{{ $field['name'] }}" 
                               id="{{ $field['name'] }}" 
                               class="form-control"
                               @foreach ($field['attributes'] ?? [] as $attr => $val)
                                    {{ $attr }}="{{ $val }}"
                                @endforeach
                            >
                    @elseif ($field['type'] === 'textarea')
                        <textarea name="{{ $field['name'] }}" 
                                  id="{{ $field['name'] }}" 
                                  class="form-control">{{ $field['value'] }}</textarea>
                    @elseif ($field['type'] === 'select')
                        <select name="{{ $field['name'] }}" id="{{ $field['name'] }}" class="form-control form-select">
                            @foreach ($field['options'] as $optionValue => $optionLabel)
                                <option value="{{ $optionValue }}" 
                                    {{ $optionValue == $field['value'] ? 'selected' : '' }}>
                                    {{ $optionLabel }}
                                </option>
                            @endforeach
                        </select>
                    @endif
        
                    @error($field['name'])
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            @endforeach
        
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection

@foreach ($list_item as $item)
    @foreach ($item->modals_form as $modal_title => $modal_data)
    <div class="modal fade" data-bs-backdrop="static"  id="samedata-modal-{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="{{ $modal_data['action_url'] }}" method="POST">
                    @csrf

                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title" id="exampleModalLabel1">
                            {{ $modal_title }}
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-3">
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
                                <select name="{{ $field['name'] }}" id="{{ $field['name'] }}" class="form-select">
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn  btn-light" data-bs-dismiss="modal">
                        Tutup
                        </button>
                        <button type="submit" class="btn  btn-success">
                        Lanjutkan
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal -->
    </div>
    @endforeach
@endforeach
@props([
    'label' => 'Meta Information',
    'name' => 'meta',
    'values' => [],
    'error' => null,
    'required' => false,
])

@php
$oldValues = old($name) ? json_decode(old($name), true) : $values;
@endphp

<div {{ $attributes->merge(['class' => 'my-3']) }}>
    <label for="{{ $name }}" class="form-label fw-semibold">
        {{ $label }}
        @if($required)
            <span class="text-danger">*</span>
        @endif
    </label>

    <div id="{{ $name }}-wrapper">
        @foreach ($oldValues ?: [['key' => '', 'value' => '']] as $index => $pair)
            <div class="row g-2 mb-2 meta-row">
                <div class="col-md-5">
                    <input type="text" class="form-control" name="meta_keys[]" placeholder="Key" value="{{ $pair['key'] ?? '' }}">
                </div>
                <div class="col-md-5">
                    <input type="text" class="form-control" name="meta_values[]" placeholder="Value" value="{{ $pair['value'] ?? '' }}">
                </div>
                <div class="col-md-2 d-flex align-items-center justify-content-center">
                    <button type="button" class="btn btn-outline-danger btn-sm remove-row">Remove</button>
                </div>
            </div>
        @endforeach
    </div>

    <button type="button" class="btn btn-sm btn-outline-primary mb-2" id="add-meta">+ Add Key-Value Pair</button>

    <!-- Hidden final JSON input -->
    <input type="hidden" name="{{ $name }}" id="{{ $name }}-final">

    @if ($error)
        <div class="text-danger mt-1 text-end small">{{ $error }}</div>
    @endif
</div>

@push('scripts')
<script>
    $(document).ready(function () {
        function updateHiddenInput() {
            let data = [];
            $('#{{ $name }}-wrapper .meta-row').each(function () {
                const key = $(this).find('input[name="meta_keys[]"]').val();
                const value = $(this).find('input[name="meta_values[]"]').val();
                if (key || value) {
                    data.push({ key, value });
                }
            });
            $('#{{ $name }}-final').val(JSON.stringify(data));
        }

        $('#{{ $name }}-wrapper').on('input', 'input', updateHiddenInput);
        $('#{{ $name }}-wrapper').on('click', '.remove-row', function () {
            $(this).closest('.meta-row').remove();
            updateHiddenInput();
        });

        $('#add-meta').on('click', function () {
            const row = `
                <div class="row g-2 mb-2 meta-row">
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="meta_keys[]" placeholder="Key">
                    </div>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="meta_values[]" placeholder="Value">
                    </div>
                    <div class="col-md-2 d-flex align-items-center justify-content-center">
                        <button type="button" class="btn btn-outline-danger btn-sm remove-row">Remove</button>
                    </div>
                </div>`;
            $('#{{ $name }}-wrapper').append(row);
            updateHiddenInput();
        });

        updateHiddenInput(); // Initial sync
    });
</script>
@endpush

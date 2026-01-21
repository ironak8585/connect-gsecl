@props([
    'label',
    'name' => null,
    'value' => '',
    'options' => [],
    'error' => null,
    'required' => false,
    'placeholder' => 'Search...'
])

@php
    // Ensure options are flattened if passed as associative array
    $flatOptions = collect($options)->map(fn($v, $k) => is_numeric($k) ? $v : $v)->values();
    $inputId = $name ?? \Illuminate\Support\Str::slug($label);
@endphp

<div class="mb-3 position-relative {{ $attributes->get('class') }}">
    <label for="{{ $inputId }}" class="form-label fw-semibold">
        {{ $label }}
        @if($required)
            <span class="text-danger">*</span>
        @endif
    </label>

    <input type="text"
        id="{{ $inputId }}_search"
        class="form-control"
        placeholder="{{ $placeholder }}"
        autocomplete="off"
    >

    <input type="hidden" name="{{ $name }}" id="{{ $inputId }}" value="{{ old($name, $value) }}">

    <ul class="list-group position-absolute w-100 shadow-sm mt-1 d-none" id="{{ $inputId }}_dropdown" style="z-index: 1050; max-height: 200px; overflow-y: auto;">
        @foreach ($flatOptions as $option)
            <li class="list-group-item list-group-item-action" data-value="{{ $option }}">{{ $option }}</li>
        @endforeach
    </ul>

    @if ($error)
        <div class="text-danger mt-1 text-end small">{{ $error }}</div>
    @endif
</div>

@once
@push('scripts')
<script>
    $(document).ready(function () {
        $('[id$="_search"]').each(function () {
            const searchInput = $(this);
            const baseId = this.id.replace('_search', '');
            const dropdown = $('#' + baseId + '_dropdown');
            const hiddenInput = $('#' + baseId);

            searchInput.on('input focus', function () {
                const query = $(this).val().toLowerCase();
                dropdown.find('li').each(function () {
                    const text = $(this).text().toLowerCase();
                    $(this).toggle(text.includes(query));
                });
                dropdown.removeClass('d-none');
            });

            dropdown.on('click', 'li', function () {
                const selected = $(this).text();
                searchInput.val(selected);
                hiddenInput.val(selected);
                dropdown.addClass('d-none');
            });

            $(document).on('click', function (e) {
                if (!$(e.target).closest(searchInput).length && !$(e.target).closest(dropdown).length) {
                    dropdown.addClass('d-none');
                }
            });
        });
    });
</script>
@endpush
@endonce

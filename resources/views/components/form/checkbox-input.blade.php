@props([
    'label',
    'name',
    'options',
    'value' => [],
    'error' => null,
    'required' => false,
    'selectAll' => false // set to true to enable Select All / Deselect All
])

@php
    $selected = old($name, $value);
    $uid = uniqid($name . '_');
@endphp

<div {{ $attributes->merge(['class' => 'my-2']) }} id="{{ $uid }}">
    <label class="form-label font-sans antialiased text-md text-stone-800 dark:text-white font-semibold">
        {{ $label }}
        @if($required)
            <span class="text-red-500">*</span>
        @endif
    </label>

    @if($selectAll)
    <div class="form-check mb-1">
        <input type="checkbox" class="form-check-input select-all" id="select_all_{{ $uid }}">
        <label class="form-check-label text-sm text-muted" for="select_all_{{ $uid }}">
            Select All
        </label>
    </div>
    @endif

    @foreach ($options as $checkboxValue => $title)
        <div class="form-check">
            <input
                type="checkbox"
                name="{{ $name }}[]"
                id="{{ $name }}_{{ $checkboxValue }}"
                class="form-check-input item-checkbox"
                value="{{ $checkboxValue }}"
                {{ in_array($checkboxValue, $selected ?? []) ? 'checked' : '' }}
            >
            <label for="{{ $name }}_{{ $checkboxValue }}" class="form-check-label text-stone-800 dark:text-gray-400">
                {{ $title }}
            </label>
        </div>
    @endforeach

    @if ($error)
        <div class="text-danger text-end mt-1 text-stone-800 dark:text-gray-400">{{ $error }}</div>
    @endif
</div>

@if($selectAll)
@once
    @push('scripts')
    <script>
        $(document).ready(function () {
            $('[id^="{{ $name }}_"]').closest('[id^="{{ $name }}_"]').each(function () {
                var container = $(this);
                container.find('.select-all').on('change', function () {
                    container.find('.item-checkbox').prop('checked', $(this).is(':checked'));
                });

                container.find('.item-checkbox').on('change', function () {
                    let allChecked = container.find('.item-checkbox').length === container.find('.item-checkbox:checked').length;
                    container.find('.select-all').prop('checked', allChecked);
                });
            });
        });
    </script>
    @endpush
@endonce
@endif

@props([
    'label',
    'name',
    'error' => null,
    'required' => false,
    'value' => null, // existing file URL or path (for edit mode)
])

@php
    $defaults = [
        'id' => $name,
        'name' => $name,
        'type' => 'file',
        'class' => 'form-control',
    ];

    $fileName = $value ? basename($value) : null;
@endphp

<div {{ $attributes->merge(['class' => 'mb-3']) }}>
    <label for="{{ $name }}" class="form-label fw-semibold">
        {{ $label }}
        @if($required)
            <span class="text-danger">*</span>
        @endif
    </label>

    @if ($value)
        {{-- Edit mode: show input with eye icon inside --}}
        <div class="input-group">
            <input
                {{ $attributes->merge($defaults) }}
                aria-label="File input with view button"
                {{-- DO NOT set value for file inputs --}}
                @if($required && !$value) required @endif
            >

            <button type="button" title="{{ $fileName }}" class="btn btn-outline-secondary"
                    onclick="window.open('{{ $value }}', '_blank')">
                <i class="bi bi-eye"></i>
            </button>
        </div>

    @else
        {{-- Create mode: regular file input --}}
        <input {{ $attributes->merge($defaults) }} @if($required) required @endif>
    @endif

    @if ($error)
        <div class="text-danger mt-1 text-end small">{{ $error }}</div>
    @endif
</div>

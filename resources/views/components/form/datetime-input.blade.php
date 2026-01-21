@php
    $now = now()->format('Y-m-d\TH:i');
@endphp

@props([
    'label',
    'name',
    'value' => null,
    'error' => null,
    'required' => false,
    'noPast' => false,
])

<div {{ $attributes->merge(['class' => 'mb-3']) }}>
    <label for="{{ $name }}" class="form-label fw-semibold">
        {{ $label }}
        @if($required)
            <span class="text-danger">*</span>
        @endif
    </label>
    <input
        type="datetime-local"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        {{ $required ? 'required' : '' }}
        {{ $noPast ? "min=$now" : '' }}
        {{ $attributes->except(['class'])->merge(['class' => 'form-control']) }}
    >

    @if ($error)
        <div class="text-danger mt-1">{{ $error }}</div>
    @endif
</div>
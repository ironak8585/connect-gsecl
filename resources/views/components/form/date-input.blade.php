@php
$today = now()->format('Y-m-d');
@endphp

@props([
'label',
'name' => null,
'value' => null,
'error' => null,
'required' => false,
'noPast' => false,
])

<div {{ $attributes->merge(['class' => '']) }}>
    <label for="{{ $name }}" class="form-label fw-semibold">
        {{ $label }}
        @if($required)
            <span class="text-danger">*</span>
        @endif
    </label>
    <input
        type="date"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        {{ $required ? 'required' : '' }}
        {{ $noPast ? "min=$today" : '' }}
        {{ $attributes->except(['class'])->merge(['class' => 'form-control']) }}
    >

    @if ($error)
        <div class="text-danger mt-1">{{ $error }}</div>
    @endif
</div>

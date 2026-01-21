@props(['label', 'name' => null, 'error' => null, 'value' => null, 'required' => false])

@php
    $defaults = [
        'id' => $name,
        'name' => $name,
        'class' => 'form-control',
        'rows' => 3,
    ];
@endphp

<div {{ $attributes->merge(['class' => '']) }}>
    <label for="{{ $name ?? $label }}" class="form-label fw-semibold">
        {{ $label }}
        @if($required)
            <span class="text-danger">*</span>
        @endif
    </label>

    <textarea {{ $attributes->merge($defaults) }}>{{ old($name, $value) }}</textarea>

    @if ($error)
        <div class="invalid-feedback d-block">
            {{ $error }}
        </div>
    @endif
</div>
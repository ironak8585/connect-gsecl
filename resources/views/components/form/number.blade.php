@props([
    'label' => null, 
    'name', 
    'value' => null, 
    'noLabel' => false, 
    'required' => false, 
    'isReadOnly' => false, 
    'error' => null
])

@if (!$noLabel)
    <label for="{{ $name ?? $label }}" class="form-label fw-semibold">
        {{ $label }}
        @if($required)
            <span class="text-danger">*</span>
        @endif
    </label>
@endif
<div class="">
    <input id="{{ $name }}"  type="number" name="{{ $name }}" value="{{ old($name, $value) }}" 
    {{ $required && !$isReadOnly ? 'required' : '' }} {{ $isReadOnly ? 'readonly disabled' : '' }} {{ $attributes->except('class')->merge(['class' => 'form-control']) }} >

    @if ($error)
        <div class="text-danger mt-1 text-end small">
            {{ $error }}
        </div>
    @endif
</div>
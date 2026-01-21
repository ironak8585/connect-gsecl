@props(['name', 'label' => null, 'value' => null, 'noLabel' => false, 'required' => false, 'isReadOnly' => false])

@if (!$noLabel)
    <label for="{{ $name ?? $label }}" class="form-label fw-semibold">
        {{ $label }}
        @if($required)
            <span class="text-danger">*</span>
        @endif
    </label>
@endif
<input class="form-control" type="text" name="{{ $name }}" id="{{ strtolower(str_replace('_', '-', $name)) }}"
    value="{{ old($name, $value) }}" 
    {{ $required && !$isReadOnly ? 'required' : '' }}
    {{ $isReadOnly ? 'readonly disabled' : '' }}>
<div class="invalid-feedback">Enter {{ __($label ?? ucwords(str_replace('_', ' ', $name))) }}!</div>
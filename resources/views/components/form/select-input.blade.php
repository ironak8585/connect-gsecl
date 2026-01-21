@props([
    'id' => '',
    'name',
    'label' => '',
    'options' => [], // ['value' => 'Label']
    'selected' => null,          // for edit forms
    'defaultSelected' => null,   // for create forms
    'required' => false,
    'isDummyRequired' => false,  // <-- new prop
    'error' => null,
])

@php
    // Resolve the selected value priority: old input > selected > defaultSelected
    $resolvedSelected = old($name, $selected ?? $defaultSelected);
@endphp

<div>
    <label for="{{ $name ?? $label }}" class="form-label fw-semibold">
        {{ $label }}
        @if($required)
            <span class="text-danger">*</span>
        @endif
    </label>
    <select id="{{ $id ?: $name }}" name="{{ $name }}" class="form-select" @if($required) required @endif>
        @if($isDummyRequired)
            <option value="" {{ is_null($resolvedSelected) ? 'selected' : '' }}>
                -- Select {{ $label ?: 'Option' }} --
            </option>
        @endif
        @foreach($options as $value => $text)
            <option value="{{ $value }}" {{ (string) $resolvedSelected === (string) $value ? 'selected' : '' }}>
                {{ $text }}
            </option>
        @endforeach
    </select>

    @if ($error)
        <div class="text-danger mt-1 text-end small">
            {{ $error }}
        </div>
    @endif
</div>

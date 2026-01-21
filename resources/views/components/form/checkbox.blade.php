@props([
    'name',
    'label' => null,
    'noLabel' => false,
    'values' => [], // ['admin' => 'Admin', 'user' => 'User']
    'grid' => false,
    'selected' => [], // <-- NEW: for pre-checked values
])

@php
    $labelText = $label ?? ucwords(str_replace('_', ' ', $name));
    // If old() exists, override selected with old input
    $selectedValues = is_array(old($name)) ? old($name) : $selected;
@endphp

@if (!$noLabel)
    <label class="form-label d-block">{{ $labelText }}</label>
@endif

<div @class(['row' => $grid])>
    @foreach ($values as $value => $text)
        @php
            $id = strtolower(str_replace('_', '-', $name)) . '-' . strtolower(str_replace(' ', '-', $value));
            $isChecked = in_array($value, $selectedValues);
        @endphp
        <div @class(['col-md-4' => $grid, 'form-check' => !$grid]) class="form-check">
            <input class="form-check-input"
                   type="checkbox"
                   name="{{ $name }}[]"
                   id="{{ $id }}"
                   value="{{ $value }}"
                   {{ $isChecked ? 'checked' : '' }}>
            <label class="form-check-label" for="{{ $id }}">
                {{ __($text) }}
            </label>
        </div>
    @endforeach
</div>

@error($name)
    <div class="invalid-feedback d-block">{{ $message }}</div>
@enderror

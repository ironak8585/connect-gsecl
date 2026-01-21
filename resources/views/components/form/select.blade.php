@props([
    'id' => '',
    'name',
    'label' => '',
    'options' => [],     // ['value' => 'Label']
    'selected' => null,
    'required' => false
])
<label for="{{ $id ?? $name }}" class="form-label">{{ $label }}</label>
<select id="{{ $id ?? $name }}" name="{{ $name }}" class="form-select" @if($required) required @endif>
    <option disabled {{ is_null($selected) ? 'selected' : '' }}>Select {{ $label ?? '...' }}</option>
    @foreach($options as $value => $text)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>
            {{ $text }}
        </option>
    @endforeach
</select>

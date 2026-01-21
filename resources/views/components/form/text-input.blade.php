@props([
    'label',
    'name' => null,
    'type' => 'text',
    'value' => '',
    'error' => null,
    'required' => false
])

<div {{ $attributes->merge(['class' => '']) }}>
    <label for="{{ $name ?? $label }}" class="form-label fw-semibold">
        {{ $label }}
                @if($required)
                    <span class="text-danger">*</span>
                @endif
    </label>

<div class="relative w-full">
        <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" value="{{ old($name, $value) }}" {{
    $attributes->except('class')->merge(['class' => 'form-control']) }}
        >
    </div>

    @if ($error)
        <div class="text-danger text-end mt-1">{{ $error }}</div>
    @endif
</div>
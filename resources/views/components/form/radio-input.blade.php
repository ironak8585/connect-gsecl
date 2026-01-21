@props(['label', 'name', 'options', 'error' => null, 'required' => false])

<div {{ $attributes->merge(['class' => 'mb-3']) }}>
    <label class="form-label fw-bold fs-6 mb-2 d-block">
        {{ $label }}
        @if ($required)
            <span class="text-danger">*</span>
        @endif
    </label>

    @foreach ($options as $value => $title)
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="{{ $name }}" id="{{ $name }}_{{ $value }}"
                value="{{ $value }}" {{ old($name) == $value ? 'checked' : '' }}>
            <label class="form-check-label" for="{{ $name }}_{{ $value }}">
                {{ $title }}
            </label>
        </div>
    @endforeach

    @if ($error)
        <div class="text-danger mt-1 text-end small">{{ $error }}</div>
    @endif
</div>
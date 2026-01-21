@props([
    'label' => '',
    'value' => '',
    'icon' => 'filetype-json',
])
@php
    // Try to decode JSON string into array/object
    $decoded = null;
    $isJson = false;

    if (is_string($value)) {
        $decoded = json_decode($value, true);
        $isJson = json_last_error() === JSON_ERROR_NONE;
    } elseif (is_array($value) || is_object($value)) {
        $decoded = (array) $value;
        $isJson = true;
    }
@endphp

<div class="border rounded p-3 mb-3 bg-white">
    <div class="text-muted mb-1">
        <i class="bi bi-{{ $icon }} me-1"></i> {{ $label }}
</div>

<div class="fs-6 fw-semibold font-monospace text-break" style="white-space: pre-wrap;">
        @if ($isJson)
            {{ json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}
        @else
            {{ $value }}
        @endif
    </div>
</div>

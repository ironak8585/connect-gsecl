@props([
    'label' => '',
    'value' => '',
    'icon' => 'text-right',
])

<div class="border rounded p-3 mb-3 bg-white">
    <div class="text-muted mb-1">
        <i class="bi bi-{{ $icon }} me-1"></i> {{ $label }}
    </div>
    <div {{ $attributes->merge(['class' => 'fs-5 fw-semibold']) }}>
        {{ $value }}
    </div>
</div>

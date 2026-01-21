@props([
    'label' => 'Link',
    'icon' => 'eye',
    'url',         // e.g., 'admin.permissions'
    'id',
    'can' => null
])

@if(is_null($can) || auth()->user()->can($can))
    <a href="{{ $url }}" class="btn btn-info">
        <i class="bi bi-{{ $icon }} me-1"></i> {{ $label }}
    </a>
@endif

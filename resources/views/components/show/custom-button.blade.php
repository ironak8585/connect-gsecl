@props([
    'label',
    'icon' => 'arrow-up-right-square-fill',
    'route',           // e.g., 'admin.permissions'
    'can' => null      // optional permission like 'create permission'
])

@if(is_null($can) || auth()->user()->can($can))
    <a href="{{ route("$route") }}" class="btn btn-success">
        <i class="bi bi-{{ $icon }} me-1"></i> {{ $label }}
    </a>
@endif

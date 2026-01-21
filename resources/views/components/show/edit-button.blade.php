@props([
    'label' => 'Edit',
    'icon' => 'pencil-square',
    'route',         // e.g., 'admin.permissions'
    'id',
    'can' => null
])

@if(is_null($can) || auth()->user()->can($can))
    <a href="{{ route("{$route}.edit", $id) }}" class="btn btn-primary">
        <i class="bi bi-{{ $icon }} me-1"></i> {{ $label }}
    </a>
@endif

@props([
    'label' => 'List',
    'icon' => 'list-task',
    'route',         // e.g., 'admin.permissions'
    'can' => null    // optional permission to view list
])

@if (is_null($can) || (auth()->check() && auth()->user()->can($can)))
    <a href="{{ route("{$route}.index") }}" class="btn btn-secondary">
        <i class="bi bi-{{ $icon }} me-1"></i> {{ $label }}
    </a>
@endif

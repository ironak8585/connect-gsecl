@props([
    'label' => 'Restore',
    'icon' => 'arrow-counterclockwise',
    'route',         // e.g., 'admin.permissions'
    'id',
    'can' => null,
    'confirm' => 'Are you sure you want to restore this item?'
])

@if(is_null($can) || auth()->user()->can($can))
    <form action="{{ route("{$route}.restore", $id) }}" method="POST" class="d-inline"
              onsubmit="return confirm('{{ $confirm }}')">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-secondary">
                <i class="bi bi-{{ $icon }} me-1"></i> {{ $label }}
            </button>
        </form>
@endif

@props([
    'label' => 'Archive',
    'icon' => 'archive',
    'route',         // e.g., 'admin.permissions'
    'id',
    'can' => null,
    'confirm' => 'Are you sure you want to archive this item?'
])

@if(is_null($can) || auth()->user()->can($can))
    <form action="{{ route("{$route}.archive", $id) }}" method="POST" class="d-inline"
              onsubmit="return confirm('{{ $confirm }}')">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-warning text-white">
                <i class="bi bi-{{ $icon }} me-1"></i> {{ $label }}
            </button>
        </form>
@endif

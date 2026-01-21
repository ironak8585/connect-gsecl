@props([
    'label' => 'Delete',
    'icon' => 'trash',
    'route',         // e.g., 'admin.permissions'
    'id',
    'can' => null,
    'confirm' => 'Are you sure?'
])

@if(is_null($can) || auth()->user()->can($can))
    <form action="{{ route("{$route}.destroy", $id) }}" method="POST" class="d-inline"
              onsubmit="return confirm('{{ $confirm }}')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="bi bi-{{ $icon }} me-1"></i> {{ $label }}
            </button>
        </form>
@endif

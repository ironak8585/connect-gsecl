@props([
    'model',
    'route',
    'show' => true,
    'edit' => false,
    'delete' => false,
    'archive' => false,
    'unarchive' => false,
    'restore' => false,
    'read' => null,     // optional permission for read action
    'can' => null,      // optional permission for manage actions
])

<div class="d-flex justify-content-end gap-1">

    @if(!$model->trashed())

        {{-- SHOW (Fixed for Guest Users) --}}
        @if($show && (is_null($read) || (auth()->check() && auth()->user()->can($read))))
            <a href="{{ route("{$route}.show", $model->id) }}" class="btn btn-sm btn-info"
            data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Show">
                <i class="bi bi-eye"></i>
            </a>
        @endif

        {{-- EDIT (Fixed for Guest Users) --}}
        @if($edit && (is_null($can) || (auth()->check() && auth()->user()->can($can))))
            <a href="{{ route("{$route}.edit", $model->id) }}" class="btn btn-sm btn-primary"
            data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Edit">
                <i class="bi bi-pencil-square"></i>
            </a>
        @endif

        {{-- ARCHIVE (Fixed for Guest Users) --}}
        @if(!$model->is_archived && $archive && (is_null($can) || (auth()->check() && auth()->user()->can($can))))
            <form action="{{ route("{$route}.archive", $model->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-sm btn-secondary"
                        data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Archive"
                        onclick="return confirm('Are you sure you want to archive this item?')">
                    <i class="bi bi-archive"></i>
                </button>
            </form>
        @endif

        {{-- UNARCHIVE (Fixed for Guest Users) --}}
        @if($model->is_archived && $unarchive && (is_null($can) || (auth()->check() && auth()->user()->can($can))))
            <form action="{{ route("{$route}.unarchive", $model->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-sm btn-info"
                        data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Unarchive"
                        onclick="return confirm('Are you sure you want to unarchive this item?')">
                    <i class="bi bi-archive-fill"></i>
                </button>
            </form>
        @endif

    @endif

    {{-- RESTORE (Fixed for Guest Users) --}}
    @if($model->trashed() && $restore && (is_null($can) || (auth()->check() && auth()->user()->can($can))))
        <form action="{{ route("{$route}.restore", $model->id) }}" method="POST" style="display:inline-block;">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-sm btn-warning"
                    data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Restore"
                    onclick="return confirm('Are you sure you want to restore this item?')">
                <i class="bi bi-reply"></i>
            </button>
        </form>
    @endif

    {{-- DELETE (Fixed for Guest Users) --}}
    @if(!$model->trashed() && $delete && (is_null($can) || (auth()->check() && auth()->user()->can($can))))
        <form action="{{ route("{$route}.destroy", $model->id) }}" method="POST" style="display:inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger"
                    data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Delete"
                    onclick="return confirm('Are you sure you want to delete this item?')">
                <i class="bi bi-trash"></i>
            </button>
        </form>
    @endif

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            // Check if the element has data-bs-toggle="tooltip" before initializing
            if (tooltipTriggerEl.getAttribute('data-bs-toggle') === 'tooltip') {
                new bootstrap.Tooltip(tooltipTriggerEl);
            }
        })
    });
</script>
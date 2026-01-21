@props([
    'label' => 'Back',
    'icon' => 'arrow-left',
    'can' => null // optional permission
])
@if(is_null($can) || auth()->user()->can($can))
    <a href="{{ url()->previous() }}" class="btn btn-dark">
        <i class="bi bi-{{ $icon }} me-1"></i> {{ $label }}
    </a>
@endif

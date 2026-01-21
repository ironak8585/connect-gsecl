@props([
    'type' => 'success', // success, error, warning
    'message' => '',
])
@php
    $bgColor = [
        'success' => 'bg-success text-white',
        'error' => 'bg-danger text-white',
        'warning' => 'bg-warning text-dark',
    ][$type] ?? 'bg-secondary text-white';

    $icon = [
        'success' => 'bi-check-circle-fill',
        'error' => 'bi-x-circle-fill',
        'warning' => 'bi-exclamation-triangle-fill',
    ][$type] ?? 'bi-info-circle-fill';

    $title = ucfirst($type);
@endphp

<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1100;">
    <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header {{ $bgColor }}">
            <i class="bi {{ $icon }} me-2"></i>

                           <strong class="me-auto">{{ $title }}</strong>
            <small>Just now</small>
            <button type="button" class="btn-close btn-close-white ms-2 mb-1" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            {{ $message }}
        </div>
    </div>
</div>

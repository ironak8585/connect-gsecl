@props([
    'label' => 'Link',
    'viewLabel' => 'View',
    'linkLable' => 'Download',
    'labelIcon' => 'person-bounding-box',
    'viewIcon' => 'eye',
    'url',
    'id' => null,
    'can' => null
])

@if(is_null($can) || auth()->user()->can($can))
    <div class="border rounded p-3 mb-3 bg-white">
        <div class="text-muted mb-1">
            <i class="bi bi-{{ $labelIcon }} me-1"></i> {{ $label }}
        </div>
        <div class="fs-5 fw-semibold d-flex gap-3">
            {{-- View Link --}}
            <a href="{{ $url }}" target="_blank" class="text-primary">
                <i class="bi bi-{{ $viewIcon }} me-1"></i> {{ $linkLable }}
            </a>
        </div>
    </div>
@endif

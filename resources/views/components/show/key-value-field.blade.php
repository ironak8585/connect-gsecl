@props([
    'label' => '',
    'value' => [], // associative array like ['name' => 'description']
    'icon' => 'list-ul',
    'navigable' => 'null',
])

<div class="border rounded p-3 mb-3 bg-white">
    <div class="text-muted mb-2">
        <i class="bi bi-{{ $icon }} me-1"></i> {{ $label }}
    </div>

    @if (!empty($value))
        <ul class="list-group list-group-flush small">
            @foreach ($value as $key => $text)
                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                    @if($navigable)
                        <a href="#"><span class="text-muted font-monospace">{{ $key }}</span></a>
                        <span class="fw-semibold text-end">{{ $text }}</span>
                    @else
                        <span class="text-muted font-monospace">{{ $key }}</span>
                        <span class="fw-semibold text-end">{{ $text }}</span>
                    @endif
                </li>
            @endforeach
        </ul>
    @else
        <div class="text-muted fst-italic">No data available</div>
    @endif
</div>

@props([
    'label' => '',
    'triple' => false,
    'color' => null,       // bootstrap color class
    'thickness' => null,   // border thickness
    'textColor' => null,   // text color class
    'uppercase' => true,   // by default text is uppercase
])

@php
    // Build line classes
    $lineClass = 'border-top flex-grow-1';
    $lineClass .= $color ? " border-$color" : '';
    $lineClass .= $thickness ? " border-$thickness" : '';

    // Build text classes
    $textClass = 'px-3 fw-semibold small';
    $textClass .= $textColor ? " text-$textColor" : ' text-secondary';
    $textClass .= $uppercase ? ' text-uppercase' : '';
@endphp

<div class="my-4 d-flex align-items-center w-100 text-center">

    {{-- Left side --}}
    @if($triple)
        <div class="flex-grow-1">
            <div class="{{ $lineClass }} mb-1"></div>
            <div class="{{ $lineClass }} mb-1"></div>
            <div class="{{ $lineClass }}"></div>
        </div>
    @else
        <div class="{{ $lineClass }}"></div>
    @endif

    {{-- Label --}}
    @if($label)
        <span class="{{ $textClass }}">
            {{ $label }}
        </span>
    @endif

    {{-- Right side --}}
    @if($triple)
        <div class="flex-grow-1">
            <div class="{{ $lineClass }} mb-1"></div>
            <div class="{{ $lineClass }} mb-1"></div>
            <div class="{{ $lineClass }}"></div>
        </div>
    @else
        <div class="{{ $lineClass }}"></div>
    @endif

</div>

{{-- 
<x-hr-label 
    label="Final Stage"
    triple
    color="dark"
    thickness="3"
    textColor="danger"
    uppercase="false"
/>
--}}
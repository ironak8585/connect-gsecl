<div class="pagetitle">
    <h1>{{ $title }}</h1>
    <nav>
        <ol class="breadcrumb">
            @foreach ($breadcrumbs as $label => $url)
            <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">
                @if ($loop->last)
                {{ $label }}
                @else
                <a href="{{ $url }}">{{ $label }}</a>
                @endif
            </li>
            @endforeach
        </ol>
    </nav>
</div>
<hr>
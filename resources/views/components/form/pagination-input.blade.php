@props(['records'])

<div class="d-flex justify-content-between align-items-center py-3">

    {{-- Records per page dropdown --}}
    <div class="input-group input-group-sm w-auto">
        <span class="input-group-text">Records per page</span>
        <form id="rpp-form" method="GET" action="{{ url()->current() }}">
            <select name="rpp" class="form-select" onchange="this.form.submit()">
                @foreach([10, 25, 50, 100] as $rppOption)
                    <option value="{{ $rppOption }}" {{ request('rpp') == $rppOption ? 'selected' : '' }}>
                        {{ $rppOption }}
                    </option>
                @endforeach
            </select>
            {{-- Hidden fields to preserve existing filters --}}
            @foreach (request()->except(['page', 'rpp']) as $key => $value)
                @if (is_array($value))
                    @foreach($value as $subValue)
                        <input type="hidden" name="{{ $key }}[]" value="{{ $subValue }}">
                    @endforeach
                @else
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endif
            @endforeach
        </form>
    </div>

    {{-- Showing results information in the middle --}}
    <div class="text-muted small">
        Showing
        <span class="fw-semibold">{{ $records->firstItem() }}</span>
        to
        <span class="fw-semibold">{{ $records->lastItem() }}</span>
        of
        <span class="fw-semibold">{{ $records->total() }}</span>
        results
    </div>

    {{-- Navigation links on the right (only show if there are multiple pages) --}}
    @if ($records->hasPages())
        <div>
            {{ $records->onEachSide(1)->links('pagination::bootstrap-4') }}
        </div>
    @endif
</div>
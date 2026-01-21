<div>
    <button id="open-filter" type="button" title="Open Filters" class="btn btn-primary me-2"
        data-bs-toggle="offcanvas" data-bs-target="#filter-panel" aria-controls="filter-panel">
        <i class="bi bi-funnel"></i>
    </button>

    @php
        $disabled = count($filters) === 0;
    @endphp

    <button type="button" onclick="window.location.href = '{{ route($route) }}'" title="Clear Filters"
        class="btn btn-success {{ $disabled ? 'disabled' : '' }}">
        <i class="bi bi-x-square"></i>
    </button>

    <div id="filter-panel" class="offcanvas offcanvas-end border-start" tabindex="-1" aria-labelledby="filter-panel-label">
        <div class="offcanvas-header border-bottom d-flex align-items-center justify-content-between">
            <h5 class="offcanvas-title me-auto" id="filter-panel-label">Filters</h5>
            <div class="d-flex gap-2">
                <button type="submit" form="filter-form" class="btn btn-primary">
                    <i class="ri-check-fill"></i>
                </button>

                <button type="button" onclick="window.location.href = '{{ route($route) }}'"
                    class="btn btn-success {{ $disabled ? 'disabled' : '' }}">
                    <i class="bi bi-eraser"></i>
                </button>

                <button type="button" class="btn btn-danger" data-bs-dismiss="offcanvas">
                    <i class="ri-close-fill"></i>
                </button>
            </div>
        </div>

        <div class="offcanvas-body">
            <form id="filter-form" method="GET" action="{{ route($route) }}">
                <div class="mb-3">
                    @foreach ($fields as $name => $item)
                        @switch($item[0])
                            @case('text')
                                <x-form.text-input :label="$item[1]" :name="$name" :value="request($name)" class="mb-2"/>
                                @break
                            @case('select')
                                <x-form.select-input :label="$item[1]" :name="$name" :options="$item[2]" :value="request($name)" :isDummyRequired="true" class="mb-2"/>
                                @break
                            @case('number')
                                <x-form.text-input :label="$item[1]" type="number" :name="$name" :value="request($name)" class="mb-2"/>
                                @break
                            @case('auto')
                                <x-form.autocomplete-input :name="$name" :label="$item[1]" :options="$item[2]" :value="request($name)" class="mb-2"/>
                                @break
                            @case('date')
                                <x-form.date-input :name="$name" :label="$item[1]" :value="request($name)" class="mb-2"/>
                                @break
                            @case('range')
                                @switch($item[1])
                                    @case('number')
                                        <div class="row mb-3">
                                            <div class="col">
                                                <x-form.text-input type="number" :name="$name . '_from'" :label="$item[2]" :value="request($name.'_from')"  class="mb-2"/>
                                            </div>
                                            <div class="col">
                                                <x-form.text-input type="number" :name="$name . '_to'" :label="false" :value="request($name.'_to')"  class="mb-2"/>
                                            </div>
                                        </div>
                                        @break
                                    @case('date')
                                        <x-form.date-input :name="$name . '_from'" :label="$item[2]" :value="request($name.'_from')"  class="mb-2"/>
                                        <div class="text-center my-2 text-muted">to</div>
                                        <x-form.date-input :name="$name . '_to'" :label="false" :value="request($name.'_to')"  class="mb-2"/>
                                        @break
                                @endswitch
                                @break
                        @endswitch
                    @endforeach
                </div>
            </form>
        </div>
    </div>
</div>
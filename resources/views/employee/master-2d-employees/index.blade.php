@php
    $links = [
        'Home' => '/',
        'Master Employees' => '#',
    ];

    $rowTotals = [];
    $colTotals = [];
    $grandTotal = 0;

    foreach ($designations as $designation) {
        $rowTotals[$designation] = 0;
        foreach ($organizations as $organization) {
            $rowTotals[$designation] += $counts[$designation][$organization]->total ?? 0;
            $colTotals[$organization] = ($colTotals[$organization] ?? 0) + ($counts[$designation][$organization]->total ?? 0);
            $grandTotal += $counts[$designation][$organization]->total ?? 0;
        }
    }
@endphp

<x-app-layout pageTitle="Master Employees" :breadcrumbs="$links">
    <section class="section">

        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th>Designation</th>
                    <th>Total</th>
                    @foreach ($organizations as $organization)
                        <th>
                            <a
                                href="{{ route('employee.master-2d-employees.matrix-by-organization', ['organization' => $organization]) }}">
                                {{ $organization }}
                            </a>
                        </th>
                    @endforeach
                </tr>

                {{-- Row for Column Totals --}}
                <tr>
                    <th>Total</th>
                    <th style="text-align: center;">
                        <strong>
                            <a href="{{ route('employee.master-2d-employees.master-2d-employee-listing') }}"
                                target="_blank">
                                {{ $grandTotal }}
                            </a>
                        </strong>
                    </th>
                    @foreach ($organizations as $organization)
                        <th style="text-align: center;">
                            <a href="{{ route('employee.master-2d-employees.master-2d-employee-listing', ['organization' => $organization]) }}"
                                target="_blank">
                                <strong>{{ $colTotals[$organization] ?? 0 }}</strong>
                            </a>
                        </th>
                    @endforeach
                </tr>
            </thead>

            <tbody>
                @foreach ($designations as $designation)
                    <tr>
                        <td>
                            <a
                                href="{{ route('employee.master-2d-employees.matrix-by-designation', ['designation' => $designation]) }}">
                                <strong>{{ $designation }}</strong>
                            </a>
                        </td>

                        <td style="text-align: center;">
                            <a href="{{ route('employee.master-2d-employees.master-2d-employee-listing', ['designation' => $designation]) }}"
                                target="_blank">
                                <strong>{{ $rowTotals[$designation] ?? 0 }} </strong>
                            </a>
                        </td>

                        @foreach ($organizations as $organization)
                            <td style="text-align: center;">
                                @php
                                    $count = $counts[$designation][$organization]->total ?? 0;
                                @endphp

                                @if ($count > 0)
                                    <a
                                        href="{{ route('employee.master-2d-employees.matrix-by-designation-organization', ['designation' => $designation, 'organization' => $organization]) }}">
                                        {{ $count }}
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>

    </section>
</x-app-layout>
@php
    $links = [
        'Home' => '/',
        'Master Employees' => '/employee/master-2d-employees',
        'Departments' => '#'
    ];

    // Calculate row totals
    $rowTotals = [];
    foreach ($designations as $designation) {
        $rowTotals[$designation] = 0;
        foreach ($departments as $department) {
            $rowTotals[$designation] += $counts[$designation][$department]->total ?? 0;
        }
    }

    // Calculate column totals
    $colTotals = [];
    foreach ($departments as $department) {
        $colTotals[$department] = 0;
        foreach ($designations as $designation) {
            $colTotals[$department] += $counts[$designation][$department]->total ?? 0;
        }
    }

    // Grand total
    $grandTotal = array_sum($rowTotals);
@endphp

<x-app-layout pageTitle="Master Employees" :breadcrumbs="$links">
    <section class="section">
        <h2>Matrix for Organization: <strong>{{ $organization }}</strong></h2>

        <table border="1" class="table table-bordered table-sm" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>Designation \ Department</th>
                    <th style="text-align: center;"><strong>Total</strong></th>
                    @foreach ($departments as $department)
                        <th style="text-align: center;">{{ $department }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                {{-- Total row (second row) --}}
                <tr>
                    <td><strong>Total</strong></td>
                    <td style="text-align: center;">
                        <a href="{{ route('employee.master-2d-employees.master-2d-employee-listing', ['organization' => $organization]) }}"
                            target="_blank">
                            <strong>{{ $grandTotal }}</strong>
                        </a>
                    </td>
                    @foreach ($departments as $department)
                        <td style="text-align: center;">
                            <a href="{{ route('employee.master-2d-employees.master-2d-employee-listing', ['organization' => $organization, 'department' => $department]) }}"
                                target="_blank">
                                <strong>{{ $colTotals[$department] ?? 0 }}</strong>
                            </a>
                        </td>
                    @endforeach
                </tr>

                {{-- Data rows --}}
                @foreach ($designations as $designation)
                    <tr>
                        <td><strong>{{ $designation }}</strong></td>
                        <td style="text-align: center;">
                            <a href="{{ route('employee.master-2d-employees.master-2d-employee-listing', ['organization' => $organization, 'designation' => $designation]) }}"
                                target="_blank">
                                <strong>{{ $rowTotals[$designation] ?? 0 }}</strong>
                            </a>
                        </td>
                        @foreach ($departments as $department)
                            <td style="text-align: center;">
                                @php
                                    $count = $counts[$designation][$department]->total ?? 0;
                                @endphp

                                @if ($count > 0)
                                    <a href="{{ route('employee.master-2d-employees.master-2d-employee-listing', ['organization' => $organization, 'designation' => $designation, 'department' => $department]) }}"
                                        target="_blank">
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

        <a href="{{ route('employee.master-2d-employees.index') }}" class="btn btn-primary mt-3">← Back to Matrix</a>
    </section>
</x-app-layout>
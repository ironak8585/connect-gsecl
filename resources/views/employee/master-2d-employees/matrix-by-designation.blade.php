@php
    $links = [
        'Home' => '/',
        'Master Employees' => '/employee/master-2d-employees',
        'Designation' => '#'
    ];

    // Prepare totals
    $columnTotals = [];
    $rowTotals = [];
    $grandTotal = 0;

    foreach ($departments as $department) {
        $rowTotals[$department] = 0;

        foreach ($organizations as $organization) {
            $count = $counts[$organization][$department]->total ?? 0;
            $rowTotals[$department] += $count;
            $columnTotals[$organization] = ($columnTotals[$organization] ?? 0) + $count;
            $grandTotal += $count;
        }
    }
@endphp

<x-app-layout pageTitle="Master Employees" :breadcrumbs="$links">
    <section class="section">

        <h3>Department Matrix for Designation: {{ $designation }}</h3>

        <table border="1" class="table table-bordered table-sm" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>Department \ Organization</th>
                    <th>Total</th> {{-- Column for row totals --}}
                    @foreach ($organizations as $organization)
                        <th>{{ $organization }}</th>
                    @endforeach
                </tr>
                <tr>
                    <th>Total</th>
                    <th style="text-align: center;">
                        <a href="{{ route('employee.master-2d-employees.master-2d-employee-listing', ['designation' => $designation]) }}"
                            target="_blank">
                            <strong>{{ $grandTotal }}</strong>
                        </a>
                    </th> {{-- Grand total --}}
                    @foreach ($organizations as $organization)
                        <th style="text-align: center;">
                            <a href="{{ route('employee.master-2d-employees.master-2d-employee-listing', ['designation' => $designation, 'organization' => $organization]) }}"
                                target="_blank">
                                {{ $columnTotals[$organization] ?? 0 }}
                            </a>
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($departments as $department)
                    <tr>
                        <td><strong>{{ $department }}</strong></td>
                        <td style="text-align: center;">
                            <a href="{{ route('employee.master-2d-employees.master-2d-employee-listing', ['designation' => $designation, 'department' => $department]) }}"
                                target="_blank">
                                <strong>{{ $rowTotals[$department] ?? 0 }}</strong>
                            </a>
                        </td>
                        @foreach ($organizations as $organization)
                            <td style="text-align: center;">
                                @php
                                    $count = $counts[$organization][$department]->total ?? 0;
                                @endphp

                                @if ($count > 0)
                                    <a href="{{ route('employee.master-2d-employees.master-2d-employee-listing', ['designation' => $designation, 'department' => $department, 'organization' => $organization]) }}"
                                        target="_blank">{{ $count }}</a>
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
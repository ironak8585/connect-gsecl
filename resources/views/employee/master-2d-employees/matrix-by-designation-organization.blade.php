@php
    $links = [
        'Home' => '/',
        'Master Employees' => '/employee/master-2d-employees',
        'Designation-Department Matrix' => '#'
    ];
@endphp

<x-app-layout pageTitle="Department Matrix - {{ $designation }} in {{ $organization }}" :breadcrumbs="$links">
    <section class="section">

        <h2>Department-wise Count for <strong>{{ $designation }}</strong> in <strong>{{ $organization }}</strong></h2>

        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>Department</th>
                    <th style="text-align: center;">Count</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($departments as $department)
                    <tr>
                        <td>{{ $department }}</td>
                        <td style="text-align: center;">
                            <a href="{{ route('employee.master-2d-employees.master-2d-employee-listing', ['organization' => $organization, 'designation' => $designation, 'department' => $department]) }}"
                                target="_blank">
                                {{ $counts[$department]->total ?? 0 }}
                            </a>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td><strong>Total</strong></td>
                    <td style="text-align: center;">
                        <a href="{{ route('employee.master-2d-employees.master-2d-employee-listing', ['organization' => $organization, 'designation' => $designation]) }}"
                            target="_blank">
                            <strong>{{ $total }}</strong>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>

        <a href="{{ route('employee.master-2d-employees.index') }}" class="btn btn-primary mt-3">← Back to Matrix</a>
    </section>
</x-app-layout>
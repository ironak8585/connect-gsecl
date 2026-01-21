@php
    $links = [
        'Home' => '/',
        'Master Employees' => '/employee/master-2d-employees',
        'Listing' => '#'
    ];
@endphp

<x-app-layout pageTitle="Master Employees" :breadcrumbs="$links">
    <section class="section">

        <div class="row">
            <div class="col-md-4">
                <x-show.field label="Organization" value="{{ $organization ?? 'All Organization'}}" />
            </div>
            <div class="col-md-4">
                <x-show.field label="Department" value="{{ $department ?? 'All Department'}}" />
            </div>
            <div class="col-md-4">
                <x-show.field label="Designation" value="{{ $designation ?? 'All Designation'}}" />
            </div>
        </div>

        <!-- Table with stripped rows -->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Emp No.</th>
                    <th scope="col">Name</th>
                    <th scope="col">Department</th>
                    <th scope="col">Organization</th>
                    <th scope="col">Designation</th>
                    <th scope="col">Class</th>
                    <!-- <th scope="col">Category</th> -->
                    <th scope="col">Date of Joining</th>
                    <!-- <th scope="col">Email</th> -->
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $record)
                    <tr>
                        <th scope="row">{{ ($records->currentPage() - 1) * $records->perPage() + $loop->iteration }}</th>
                        <td>{{ $record->new_emp_no }}</td>
                        <td>{{ $record->name }}</td>
                        <td>{{ $record->department }}</td>
                        <td>{{ $record->organization }}</td>
                        <td>{{ $record->designation }}</td>
                        <td>{{ $record->class }}</td>
                        <!-- <td>{{ $record->category }}</td> -->
                        <td>{{ $record->date_of_joining }}</td>
                        <!-- <td>{{ $record->email }}</td> -->
                        <td>
                            <x-form.action-buttons :id="$record->id" :model="$record" route="employee.master-employees"
                                :delete="true" :archive="false" :restore="false" read="master_employee_read"
                                can="master_employee_manage" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $records->withQueryString()->links('pagination::bootstrap-5') }}
        </div>

    </section>
</x-app-layout>
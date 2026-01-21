@php
    $links = [
        'Home' => '/',
        'Employees' => '#',
        'Master Employees' => '#',
    ];
    $fields = [
        'employee_number' => ['number', 'Employee Number'],
        'name' => ['text', 'Name'],
        'designation' => ['text', 'Designation'],
        'organization' => ['text', 'Location']
    ]
@endphp
<x-app-layout pageTitle="Employees" :breadcrumbs="$links">
    <section class="section">

        <x-show.buttons>
            <x-system.filter-panel :fields="$fields" :filters="$filters" route="employee.master-employees.index">
            </x-system.filter-panel>
            <!-- <x-show.create-button route="employee.master-employees" can="master_employee_manage" /> -->
        </x-show.buttons>

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
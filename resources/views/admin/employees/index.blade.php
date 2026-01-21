@php
    $links = [
        'Home' => '/',
        'Employees' => '#',
    ];
    $fields = [
        'name' => ['text', 'Name'],
        'employee_number' => ['number', 'Employee Number'],
        'location' => ['select', 'Location', $locations],
        'phone' => ['text', 'Phone'],
        'email' => ['text', 'Email'],
    ]
@endphp
<x-app-layout pageTitle="EUrja Employees" :breadcrumbs="$links">
    <!-- Loader Overlay -->
    <x-show.loader message="EUrja Synchronization is in Process... Please Wait !" route="admin.eurja-employees.sync"></x-show.loader>

    <section class="section">
        <x-show.buttons>
            <!-- <x-show.custom-button route="admin.eurja-employees.sync" can="admin_eurja_employee_sync" label="Sync" /> -->
            <x-system.filter-panel :fields="$fields" :filters="$filters" route="admin.eurja-employees.index">
            </x-system.filter-panel>
        </x-show.buttons>

        <!-- Table with stripped rows -->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Employee No.</th>
                    <th scope="col">Name</th>
                    <th scope="col">Designation</th>
                    <th scope="col">Department</th>
                    <th scope="col">Location</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $record)
                
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $record->employee_number}}</td>
                        <td>{{ $record->name}}</td>
                        <td>{{ $record->designation->name }}</td>
                        <td>{{ $record->department->name }}</td>
                        <td>{{ $record->location->slug}}</td>
                        <td>
                            <a href="{{ route("admin.employees.show", $record) }}" class="btn btn-sm btn-info"
                                data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Show">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- <div class="d-flex justify-content-center">
            {{ $records->links() }}
        </div> -->
        <x-form.pagination-input :records="$records" />
    </section>
</x-app-layout>
@php
    $links = [
        'Home' => '/',
        'Departments' => '#',
    ];
    $fields = [
        'name' => ['text', 'Name'],
    ]
@endphp
<x-app-layout pageTitle="Departments" :breadcrumbs="$links">
    <section class="section">

        <x-show.buttons>
            <x-system.filter-panel :fields="$fields" :filters="$filters" route="master.departments.index">
            </x-system.filter-panel>
        </x-show.buttons>

        <!-- Table with stripped rows -->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Sub Department</th>
                    <th scope="col">Core Department</th>
                    <th scope="col">Type</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $record)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $record->name }}</td>
                        <td>{{ $record->subDepartment->name }}</td>
                        <td>{{ $record->subDepartment->coreDepartment->name }}</td>
                        <td>{{ config('constants.master.DEPARTMENT.TYPE.'.$record->type) }}</td>
                        <td>
                            <x-form.action-buttons :id="$record->id" :model="$record" route="master.departments"
                                :delete="false" :edit="true" :archive="false" :restore="false" read="master_departments_read"
                                can="master_departments_manage" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <x-form.pagination-input :records="$records" />
    </section>
</x-app-layout>
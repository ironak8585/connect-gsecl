@php
    $links = [
        'Home' => '/',
        'Sub Departments' => '#',
    ];
    $fields = [
        'name' => ['text', 'Name'],
    ]
@endphp
<x-app-layout pageTitle="Sub Departments" :breadcrumbs="$links">
    <section class="section">

        <x-show.buttons>
            <x-show.create-button route="master.sub_departments" can="master_sub_departments_manage" />
            <x-system.filter-panel :fields="$fields" :filters="$filters" route="master.sub_departments.index">
            </x-system.filter-panel>
        </x-show.buttons>

        <!-- Table with stripped rows -->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Core Department Name</th>
                    <th scope="col">Departments Count</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $record)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $record->name }}</td>
                        <td>{{ $record->coreDepartment->name }}</td>
                        <td>{{ count($record->departments) }}</td>
                        <td>
                            <x-form.action-buttons :id="$record->id" :model="$record" route="master.sub_departments"
                                :delete="true" :edit="true" :archive="false" :restore="true"
                                read="master_sub_departments_read" can="master_sub_departments_manage" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <x-form.pagination-input :records="$records" />
    </section>
</x-app-layout>
@php
    $links = [
        'Home' => '/',
        'Eurja Departments' => '#',
    ];
    $fields = [
        'name' => ['text', 'Name'],
    ]
@endphp
<x-app-layout pageTitle="Eurja Departments" :breadcrumbs="$links">
    <section class="section">

        <x-show.buttons>
            <!-- <x-show.create-button route="admin.eurja_departments" can="admin_eurja_departments_manage" /> -->
            <x-system.filter-panel :fields="$fields" :filters="$filters" route="admin.eurja_departments.index">
            </x-system.filter-panel>
        </x-show.buttons>

        <!-- Table with stripped rows -->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Code</th>
                    <th scope="col">Master</th>
                    <th scope="col">Type</th>
                    <th scope="col">Location</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $record)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $record->name }}</td>
                        <td>{{ $record->code }}</td>
                        <td>{{ $record->master }}</td>
                        <td>{{ $record->type }}</td>
                        <td>{{ $record->location_slug }}</td>
                        <td>
                            <x-form.action-buttons :id="$record->id" :model="$record" route="admin.eurja_departments"
                                :delete="false" :edit="false" :archive="false" :restore="false" read="admin_eurja_departments_read"
                                can="admin_eurja_departments_manage" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <x-form.pagination-input :records="$records" />
    </section>
</x-app-layout>
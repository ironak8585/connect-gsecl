@php
    $links = [
        'Home' => '/',
        'Core Departments' => '#',
    ];
    $fields = [
        'name' => ['text', 'Name'],
    ]
@endphp
<x-app-layout pageTitle="Core Departments" :breadcrumbs="$links">
    <section class="section">

        <x-show.buttons>
            <x-show.create-button route="master.core_departments" can="master_core_departments_manage" />
            <x-system.filter-panel :fields="$fields" :filters="$filters" route="master.core_departments.index">
            </x-system.filter-panel>
        </x-show.buttons>

        <!-- Table with stripped rows -->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Created by</th>
                    <th scope="col">Updated by</th>
                    <th scope="col">Created @</th>
                    <th scope="col">Updated @</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $record)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $record->name }}</td>
                        <td>{{ $record->creator?->name??'System' }}</td>
                        <td>{{ $record->editor?->name??'System' }}</td>
                        <td>{{ $record->created_at->format('d-m-Y') }}</td>
                        <td>{{ $record->updated_at->format('d-m-Y') }}</td>
                        <td>
                            <x-form.action-buttons :id="$record->id" :model="$record" route="master.core_departments"
                                :delete="true" :edit="true" :archive="false" :restore="true" read="master_core_departments_read"
                                can="master_core_departments_manage" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <x-form.pagination-input :records="$records" />
    </section>
</x-app-layout>
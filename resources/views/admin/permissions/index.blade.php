@php
    $links = [
        'Home' => '/',
        'Permissions' => '#',
    ];
    $fields = [
        'name' => ['text', 'Name'],
        'description' => ['text', 'Description'],
        'guard_name' => ['text', 'Guard Name']
    ]
@endphp
<x-app-layout pageTitle="Permissions" :breadcrumbs="$links">
    <section class="section">
        
        <x-show.buttons>
            <x-show.create-button route="admin.permissions" can="admin_permissions_manage" />
            <x-system.filter-panel :fields="$fields" :filters="$filters" route="admin.permissions.index">
            </x-system.filter-panel>
        </x-show.buttons>

        <!-- Table with stripped rows -->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Guard</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $record)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $record->name}}</td>
                        <td>{{ $record->description}}</td>
                        <td>{{ $record->guard_name }}</td>
                        <td>
                            <x-form.action-buttons :id="$record->id" :model="$record" route="admin.permissions" :delete="true" :archive="false"
                                :restore="true" read="admin_permissions_read" can="admin_permissions_manage" />
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
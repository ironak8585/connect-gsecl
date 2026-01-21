@php
    $links = [
        'Home' => '/',
        'Users' => '#',
    ];
    $fields = [
        'employee_number' => ['number', 'Employee No.'],
        'name' => ['text', 'Name'],
        'email' => ['text', 'Email'],
        'location_id' => ['select', 'Location', $locations ],
        'is_active' => ['select', 'Status', $status]
    ];
@endphp
<x-app-layout pageTitle="Users" :breadcrumbs="$links">
    <section class="section">
        
        <x-show.buttons>
            <x-system.filter-panel :fields="$fields" :filters="$filters" route="admin.users.index">
            </x-system.filter-panel>
            <!-- <x-show.create-button route="admin.users" can="admin_users_manage" /> -->
        </x-show.buttons>

        <!-- Table with stripped rows -->
        <table class="table datatable">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">eUrja No.</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Company</th>
                    <th scope="col">Location</th>
                    <th scope="col">Roles</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $record)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $record->employee_number }}</td>
                        <td>{{ $record->name }}</td>
                        <td>{{ $record->email }}</td>
                        <td>{{ $record->company->slug }}</td>
                        <td>{{ $record->location->slug ?? '-' }}</td>
                        <td><a class="text-primary" data-bs-toggle="modal" data-bs-target="#roles-{{ $record->id }}">{{ $record->roles->count() }}</a></td>
                        <td>{{ $record->status }}</td>
                        <td>
                            <x-form.action-buttons :id="$record->id" :model="$record" route="admin.users" :delete="true" :archive="false"
                                :restore="true" read="users_read" can="admin_users_manage" />
                        </td>
                    </tr>

                    <div class="modal fade" id="roles-{{ $record->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Roles and Permissions</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <x-show.key-value-field label="Roles" :value="$record->roles->pluck('description', 'name')" icon="shield-shaded"/>
                                    <x-show.key-value-field label="Permissions" :value="$record->getAllPermissions()->pluck('description', 'name')" icon="key"/>
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </section>
</x-app-layout>
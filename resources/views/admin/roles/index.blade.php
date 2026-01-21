@php
    $links = [
        'Home' => '/',
        'Roles' => '#',
    ];
    $fields = [
        'name' => ['text', 'Name'],
        'description' => ['text', 'Description'],
        'guard_name' => ['text', 'Guard Name']
    ]
@endphp
<x-app-layout pageTitle="Roles" :breadcrumbs="$links">
    <section class="section">
        
        <x-show.buttons>
            {{-- <x-system.filter-panel :fields="$fields" :filters="$filters" route="admin.roles.index">
            </x-system.filter-panel>
             --}}
            <x-show.create-button route="admin.roles" can="admin_roles_manage" />
        </x-show.buttons>

        <!-- Table with stripped rows -->
        <table class="table datatable">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Permissions</th>
                    <th scope="col">Guard</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $record)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $record->name}}</td>
                        <td>{{ $record->description ?? '-'}}</td>
                        <td><a class="text-primary" data-bs-toggle="modal" data-bs-target="#permissions-{{ $record->id }}">{{ $record->permissions->count() }}</a></td>
                        <td>{{ $record->guard_name }}</td>
                        <td>
                            <x-form.action-buttons :id="$record->id" :model="$record" route="admin.roles" :delete="true" :archive="false"
                                :restore="true" read="admin_roles_read" can="admin_roles_manage" />
                        </td>
                    </tr>

                    <div class="modal fade" id="permissions-{{ $record->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Permissions</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <x-show.key-value-field label="Permissions" :value="$record->permissions->pluck('description', 'name')" icon="key"/>
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
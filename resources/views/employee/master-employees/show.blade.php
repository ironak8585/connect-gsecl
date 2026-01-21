@php
    $links = [
        'Home' => '/',
        'Roles' => '/admin/roles',
        'Show' => '#'
    ];
@endphp
<x-app-layout pageTitle="Role Details" :breadcrumbs="$links">

    <x-show.buttons>
        <x-show.back-button />
        <x-show.edit-button route="admin.roles" :id="$role->id" can="admin_roles_manage" />
        <x-show.delete-button route="admin.roles" :id="$role->id" can="admin_roles_manage" />
        <x-show.list-button route="admin.roles" can="admin_roles_read" label="Roles" />
    </x-show.buttons>

    <section class="section">
        <div class="row">
            <div class="col-md-6">
                <x-show.field label="Name" value="{{ $role->name }}" />
            </div>
            <div class="col-md-9">
                <x-show.field label="Description" value="{{ $role->description ?? '-' }}" />
            </div>
            <div class="col-md-3">
                <x-show.field label="Guard Name" value="{{ $role->guard_name }}" />
            </div>
            <div class="col-md-6">
                <x-show.key-value-field label="Permissions" :value="$role->permissions->pluck('description', 'name')"
                    icon="key" />
            </div>
        </div>
    </section>
    <x-show.stamps :model="$role" />
</x-app-layout>
@php
    $links = [
        'Home' => '/',
        'Permissions' => '/admin/permissions',
        'Show' => '#'
    ];
@endphp
<x-app-layout pageTitle="Permission Details" :breadcrumbs="$links">

    <x-show.buttons>
        <x-show.back-button />
        <x-show.edit-button route="admin.permissions" :id="$permission->id" can="admin_permissions_manage" />
        <x-show.delete-button route="admin.permissions" :id="$permission->id" can="admin_permissions_manage" />
        <x-show.list-button route="admin.permissions" can="admin_permissions_read" label="Permissions" />
    </x-show.buttons>

    <section class="section">
        <div class="row">
            <div class="col-md-6">
                <x-show.field label="Name" value="{{ $permission->name }}" />
            </div>
            <div class="col-md-9">
                <x-show.field label="Description" value="{{ $permission->description }}" />
            </div>
            <div class="col-md-3">
                <x-show.field label="Guard Name" value="{{ $permission->guard_name }}" />
            </div>
        </div>
    </section>
    <x-show.stamps :model="$permission" />
</x-app-layout>
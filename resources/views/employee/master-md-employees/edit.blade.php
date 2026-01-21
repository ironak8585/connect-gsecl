@php
    $links = [
        'Home' => '/',
        'Roles' => '/admin/roles',
        'Edit' => '#'
    ];
@endphp
<x-app-layout pageTitle="Edit Role" :breadcrumbs="$links">
    <x-show.buttons>
        <x-show.back-button />
        <x-show.create-button route="admin.roles" can="admin_roles_manage" label="Create New" />
        <x-show.show-button route="admin.roles" :id="$role->id" can="admin_roles_read" />
        <x-show.delete-button route="admin.roles" :id="$role->id" can="admin_roles_manage" />
        <x-show.list-button route="admin.roles" can="admin_roles_read" label="Roles" />
    </x-show.buttons>

    <section class="section">
        <form class="row g-3" action="{{ route('admin.roles.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="col-md-6">
                <label for="role" class="form-label">Role</label>
                <input type="text" name="name" class="form-control" id="role" value="{{ $role->name }}" required>
            </div>
            <div class="col-md-12">
                <label for="description" class="form-label">Description</label>
                <input type="text" name="description" class="form-control" id="description"
                    value="{{ $role->description }}" required>
            </div>
            <div class="col-md-12">
                <x-form.checkbox name="permissions" label="Permissions" :values="$permissions"
                    :selected="$role->permissions->pluck('id')->toArray()" :grid="true" />
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
        </form><!-- End Multi Columns Form -->
    </section>
</x-app-layout>
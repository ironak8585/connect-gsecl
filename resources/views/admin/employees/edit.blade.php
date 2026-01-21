@php
    $links = [
        'Home' => '/',
        'Permissions' => '/admin/permissions',
        'Edit' => '#'
    ];
@endphp
<x-app-layout pageTitle="Edit Permission" :breadcrumbs="$links">
    <x-show.buttons>
        <x-show.back-button />
        <x-show.create-button route="admin.permissions" can="admin_permissions_manage" label="Create New" />
        <x-show.show-button route="admin.permissions" :id="$permission->id" can="admin_permissions_read" />
        <x-show.delete-button route="admin.permissions" :id="$permission->id" can="admin_permissions_manage" />
        <x-show.list-button route="admin.permissions" can="admin_permissions_read" label="Permissions" />
    </x-show.buttons>

    <section class="section">
        <form class="row g-3" action="{{ route('admin.permissions.update', $permission->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="col-md-6">
                <label for="permission" class="form-label">Permission</label>
                <input type="text" name="name" class="form-control" id="permission" value="{{ $permission->name }}"
                    required>
            </div>
            <div class="col-md-12">
                <label for="description" class="form-label">Description</label>
                <input type="text" name="description" class="form-control" id="description"
                    value="{{ $permission->description }}" required>
            </div>
            <div class="col-md-4">
                <x-form.select id="guard-name" name="guard_name" label="Guard" :options="['web' => 'Web', 'api' => 'API']"
                    :selected="old('guard_name', $permission->guard_name ?? null)" required />

            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
        </form><!-- End Multi Columns Form -->
    </section>
</x-app-layout>
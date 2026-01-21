@php
    $links = [
        'Home' => '/',
        'Roles' => '/admin/roles',
        'Add' => '#'
    ];
@endphp
<x-app-layout pageTitle="Add Role" :breadcrumbs="$links">
    <x-show.buttons>
        <x-show.back-button />
        <x-show.list-button route="admin.roles" can="admin_roles_read" label="Roles" />
    </x-show.buttons>

    <section class="section">
        <form class="row g-3" action="{{ route('admin.roles.store') }}" method="POST">
            @csrf
            <div class="col-md-6">
                <label for="Role" class="form-label">Role Name</label>
                <input type="text" name="name" class="form-control" id="Role" required>
            </div>
            <div class="col-md-12">
                <label for="description" class="form-label">Description</label>
                <input type="text" name="description" class="form-control" id="description" required>
            </div>
            <div class="col-md-12">
                <x-form.checkbox label="Permissions" name="permissions" :values="$permissions" :grid="true"
                    required></x-form.checkbox>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
        </form><!-- End Multi Columns Form -->
    </section>
</x-app-layout>
@php
    $links = [
        'Home' => '/',
        'Permissions' => '/admin/permissions',
        'Add' => '#'
    ];
@endphp
<x-app-layout pageTitle="Add Permission" :breadcrumbs="$links">
    <x-show.buttons>
        <x-show.back-button />
        <x-show.list-button route="admin.permissions" can="admin_permissions_read" label="Permissions" />
    </x-show.buttons>

    <section class="section">
        <form class="row g-3" action="{{ route('admin.permissions.store') }}" method="POST">
            @csrf
            <div class="col-md-6">
                <label for="permission" class="form-label">Permission</label>
                <input type="text" name="name" class="form-control" id="permission" required>
            </div>
            <div class="col-md-12">
                <label for="description" class="form-label">Description</label>
                <input type="text" name="description" class="form-control" id="description" required>
            </div>
            <div class="col-md-4">
                <label for="guard-name" class="form-label">Guard</label>
                <select id="guard-name" name="guard_name" class="form-select" required>
                    <option selected>Choose...</option>
                    <option value="web">Web</option>
                    <option value="api">Api</option>
                </select>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
        </form><!-- End Multi Columns Form -->
    </section>
</x-app-layout>
@php
    $links = [
        'Home' => '/',
        'Users' => '/admin/users',
        'Add' => '#'
    ];
@endphp
<x-app-layout pageTitle="Add User" :breadcrumbs="$links">
    <x-show.buttons>
        <x-show.back-button />
        <x-show.list-button route="admin.users" can="users_read" label="Users" />
    </x-show.buttons>

    <section class="section">
        <form class="row g-3" action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="col-md-2">
                <label for="employee_number" class="form-label">eUrja No.</label>
                <input type="number" name="employee_number" class="form-control" id="employee_number" required>
            </div>
            <div class="col-md-4">
                <label for="Name" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" id="Name" required>
            </div>
            <div class="col-md-4">
                <x-form.select :id="'Location'" name="location_id" label="Location" :options="$locations" required />
            </div>
            <div class="col-md-12">
                <x-form.checkbox label="Roles" name="roles" :values="$roles" :grid="true" required></x-form.checkbox>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
        </form><!-- End Multi Columns Form -->
    </section>
</x-app-layout>
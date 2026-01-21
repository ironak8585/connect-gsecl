@php
    $links = [
        'Home' => '/',
        'Users' => '/admin/users',
        'Edit' => '#'
    ];
@endphp
<x-app-layout pageTitle="Edit User" :breadcrumbs="$links">
    <x-show.buttons>
        <x-show.back-button />
        <x-show.create-button route="admin.users" can="admin_users_manage" label="Create New" />
        <x-show.show-button route="admin.users" :id="$editUser->id" can="users_read" />
        <x-show.delete-button route="admin.users" :id="$editUser->id" can="admin_users_manage" />
        <x-show.list-button route="admin.users" can="users_read" label="Users" />
    </x-show.buttons>

    <section class="section">
        <form class="row g-3" action="{{ route('admin.users.update', $editUser->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="col-md-6">
                <x-form.text label="Name" :required="true" name="name" value="{{ $editUser->name }}" :isReadOnly="true"></x-form.text>
            </div>
            <div class="col-md-4">
                <x-form.select :id="'Location'" name="location_id" label="Location" :options="$locations" :selected="$userLocation" required />
            </div>
            <div class="col-md-12">
                <x-form.checkbox label="Roles" name="roles" :values="$roles" :selected="$assignedRoles" :grid="true" required></x-form.checkbox>
            </div>
            <hr>
            <div class="">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
        </form><!-- End Multi Columns Form -->
    </section>
</x-app-layout>
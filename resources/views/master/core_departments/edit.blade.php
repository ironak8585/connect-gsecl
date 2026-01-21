@php
    $links = [
        'Home' => '/',
        'Core Departments' => '/master/core_departments',
        'Edit' => '#'
    ];
@endphp
<x-app-layout pageTitle="Edit Core Department" :breadcrumbs="$links">
    <x-show.buttons>
        <x-show.back-button />
        <x-show.create-button route="master.core_departments" can="master_core_departments_manage" label="Create New" />
        <x-show.show-button route="master.core_departments" :id="$coreDepartment->id" can="master_core_departments_read" />
        <x-show.delete-button route="master.core_departments" :id="$coreDepartment->id" can="master_core_departments_manage" />
        <x-show.list-button route="master.core_departments" can="master_core_departments_read" label="Core Departments" />
    </x-show.buttons>

    <section class="section">
        <form class="row g-3" action="{{ route('master.core_departments.update', $coreDepartment->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-md-9">
                <x-form.text label="Core Department" name="name" error="{{ $errors->first('name') }}"
                    :value="old('name', $coreDepartment->name)" :required="true" />
            </div>
            <div class="text-left">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
        </form><!-- End Multi Columns Form -->
    </section>
</x-app-layout>
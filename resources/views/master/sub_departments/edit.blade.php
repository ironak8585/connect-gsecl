@php
    $links = [
        'Home' => '/',
        'Sub Departments' => '/master/sub_departments',
        'Edit' => '#'
    ];
@endphp
<x-app-layout pageTitle="Edit Sub Department" :breadcrumbs="$links">
    <x-show.buttons>
        <x-show.back-button />
        <x-show.create-button route="master.sub_departments" can="master_sub_departments_manage" label="Create New" />
        <x-show.show-button route="master.sub_departments" :id="$subDepartment->id" can="master_sub_departments_read" />
        <x-show.delete-button route="master.sub_departments" :id="$subDepartment->id" can="master_sub_departments_manage" />
        <x-show.list-button route="master.sub_departments" can="master_sub_departments_read" label="Sub Departments" />
    </x-show.buttons>

    <section class="section">
        <form class="row g-3" action="{{ route('master.sub_departments.update', $subDepartment->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-md-7">
                <x-form.text label="Sub Department" name="name" error="{{ $errors->first('name') }}"
                    :value="old('name', $subDepartment->name)" :required="true" />
            </div>

            <div class="col-md-5">
                <x-form.select-input id="core_department_id" label="Core Department" name="core_department_id" :options="$coreDepartments"
                    :required="true" :selected="$subDepartment->core_department_id" />
            </div>
            <div class="col-md-4">
                <x-form.text label="Slug (Short Name)" name="slug" error="{{ $errors->first('slug') }}"
                    :value="old('name', $subDepartment->slug)" :required="true" />
            </div>
            <div class="text-left">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
        </form><!-- End Multi Columns Form -->
    </section>
</x-app-layout>
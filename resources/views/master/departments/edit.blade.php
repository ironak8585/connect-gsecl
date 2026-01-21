@php
    $links = [
        'Home' => '/',
        'Departments' => '/master/departments',
        'Edit' => '#'
    ];
@endphp
<x-app-layout pageTitle="Edit Department" :breadcrumbs="$links">
    <x-show.buttons>
        <x-show.back-button />
        <x-show.show-button route="master.departments" :id="$department->id" can="master_departments_read" />
        <x-show.list-button route="master.departments" can="master_departments_read" label="Departments" />
    </x-show.buttons>

    <section class="section">
        <form class="row g-3" action="{{ route('master.departments.update', $department->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <!-- <div class="col-md-7">
                <x-form.text label="Department" name="name" error="{{ $errors->first('name') }}"
                    :value="old('name', $department->name)" :required="true" />
            </div> -->
            <div class="col-md-5">
                <x-show.field label="Department Name" value="{{ $department->name }}" />
            </div>
            <div class="col-md-7">
                <x-show.field label="Eurja Department Name" value="{{ $department->eurjaDepartment->master }}" />
            </div>
            <div class="col-md-5">
                <x-form.select-input id="core_department_id" label="Core Department" name="core_department_id" :options="$coreDepartments"
                    :required="true" :selected="$department->core_department_id" />
            </div>
            <div class="col-md-5">
                <x-form.select-input id="sub_department_id" label="Sub Department" name="sub_department_id" :options="$subDepartments"
                    :required="true" :selected="$department->sub_department_id" />
            </div>
            <div class="text-left">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
        </form><!-- End Multi Columns Form -->
    </section>
</x-app-layout>
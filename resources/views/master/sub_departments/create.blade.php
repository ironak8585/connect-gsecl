@php
    $links = [
        'Home' => '/',
        'Sub Departments' => '/master/sub_departments',
        'Add' => '#'
    ];
@endphp
<x-app-layout pageTitle="Add Sub Departments" :breadcrumbs="$links">
    <x-show.buttons>
        <x-show.back-button />
        <x-show.list-button route="master.sub_departments" can="master_sub_departments_read" label="Sub Departments" />
    </x-show.buttons>

    <section class="section">
        <form class="row g-3" action="{{ route('master.sub_departments.store') }}" method="POST">
            @csrf
            <div class="col-md-4">
                <x-form.select-input id="core_department_id" label="Core Department" name="core_department_id" :options="$coreDepartments"
                    :required="true" :isDummyRequired="true"/>
            </div>
            <div class="col-md-8">
                <x-form.text label="Name" name="name" error="{{ $errors->first('name') }}"
                    :required="true" />
            </div>
            <div class="col-md-4">
                <x-form.text label="Slug (Short Name)" name="slug" error="{{ $errors->first('slug') }}"
                    :required="true" />
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
        </form>
    </section>
</x-app-layout>
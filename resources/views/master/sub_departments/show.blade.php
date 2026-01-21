@php
    $links = [
        'Home' => '/',
        'Sub Departments' => '/master/sub_departments',
        'Show' => '#'
    ];
@endphp
<x-app-layout pageTitle="Sub Department Details" :breadcrumbs="$links">

    <x-show.buttons>
        <x-show.back-button />
        <x-show.edit-button route="master.sub_departments" :id="$subDepartment->id" can="master_sub_departments_manage" />
        <x-show.delete-button route="master.sub_departments" :id="$subDepartment->id" can="master_sub_departments_manage" />
        <x-show.list-button route="master.sub_departments" can="master_sub_departments_read" label="Sub Departments" />
    </x-show.buttons>

    <section class="section">
        <div class="row">
            <div class="col-md-7">
                <x-show.field label="Sub Department Name" value="{{ $subDepartment->name }}" />
            </div>
            <div class="col-md-5">
                <x-show.field label="Core Department Name" value="{{ $subDepartment->coreDepartment->name }}" />
            </div>
            <div class="col-md-4">
                <x-show.field label="Slug (Short Name)" value="{{ $subDepartment->slug }}" />
            </div>
            <div class="col-md-4">
                <x-show.field label="Departments #" value="{{ count($subDepartment->departments) }}" />
            </div>
            <x-show.hr-label label="Departments" :triple="true" />
            @foreach ($subDepartment->departments as $department)            
                <div class="col-md-4">
                    @php
                        $departmentLink = route('master.departments.show', 
                            ['department' => $department->id]);
                    @endphp

                    <x-show.field-text-link label="Department" :url="$departmentLink" labelIcon="columns-gap" viewIcon="collection"
                        linkLable="{{ $department->department_with_type }}" />
                </div>
            @endforeach
        </div>
    </section>
    <hr>
    <x-show.stamps :model="$subDepartment" />
</x-app-layout>
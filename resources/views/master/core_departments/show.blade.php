@php
    $links = [
        'Home' => '/',
        'Core Departments' => '/master/core_departments',
        'Show' => '#'
    ];
@endphp
<x-app-layout pageTitle="Core Department Details" :breadcrumbs="$links">

    <x-show.buttons>
        <x-show.back-button />
        <x-show.edit-button route="master.core_departments" :id="$coreDepartment->id" can="master_core_departments_manage" />
        <x-show.delete-button route="master.core_departments" :id="$coreDepartment->id" can="master_core_departments_manage" />
        <x-show.list-button route="master.core_departments" can="master_core_departments_read" label="Core Departments" />
    </x-show.buttons>

    <section class="section">
        <div class="row">
            <div class="col-md-6">
                <x-show.field label="Core Department Name" value="{{ $coreDepartment->name }}" />
            </div>
            <div class="col-md-3">
                <x-show.field label="Sub Departments #" value="{{ count($coreDepartment->subDepartments) }}" />
            </div>
            <div class="col-md-3">
                <x-show.field label="Departments #" value="{{ count($coreDepartment->departments) }}" />
            </div>
            <x-show.hr-label label="Sub Departments" :triple="true" />
            @foreach ($coreDepartment->subDepartments as $subDepartment)            
                <div class="col-md-4">
                    @php
                        $subDepartmentLink = route('master.sub_departments.show', 
                            ['sub_department' => $subDepartment->id]);
                    @endphp

                    <x-show.field-text-link label="Sub Department" :url="$subDepartmentLink" labelIcon="columns-gap" viewIcon="columns"
                        linkLable="{{ $subDepartment->name }}" />
                </div>
            @endforeach
            <x-show.hr-label label="Departments" :triple="true" />
            @foreach ($coreDepartment->departments as $department)
                <div class="col-md-6">
                    @php
                        $departmentLink = route('master.departments.show', 
                            ['department' => $department->id]);
                        $departmentLinkLabel = $department->name . " | " .$department->type . " | ". $department->eurjaDepartment->location_slug;
                    @endphp

                    <x-show.field-text-link label="Department" :url="$departmentLink" labelIcon="columns-gap" viewIcon="columns"
                        linkLable="{{ $departmentLinkLabel }}" />
                </div>
            @endforeach
        </div>
    </section>
    <hr>
    <x-show.stamps :model="$coreDepartment" />
</x-app-layout>
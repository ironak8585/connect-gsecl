@php
    $links = [
        'Home' => '/',
        'Departments' => '/master/departments',
        'Show' => '#'
    ];
@endphp
<x-app-layout pageTitle="Department Details" :breadcrumbs="$links">

    <x-show.buttons>
        <x-show.back-button />
        <x-show.edit-button route="master.departments" :id="$department->id" can="master_departments_manage" />
        <x-show.list-button route="master.departments" can="master_departments_read" label="Departments" />
    </x-show.buttons>

    <section class="section">
        <div class="row">
            <div class="col-md-6">
                <x-show.field label="Department Name" value="{{ $department->name }}" />
            </div>
            <div class="col-md-3">
                <x-show.field label="Sub Department" value="{{ $department->subDepartment->name }}" />
            </div>
            <div class="col-md-3">
                <x-show.field label="Core Department" value="{{ $department->subDepartment->coreDepartment->name }}" />
            </div>
            <div class="col-md-3">
                <x-show.field label="Type"
                    value="{{ config('constants.master.DEPARTMENT.TYPE.' . $department->type) }}" />
            </div>
            <div class="col-md-9">
                <x-show.field label="Eurja Department Name" value="{{ $department->eurjaDepartment->master }}" />
            </div>
            <x-show.hr-label label="Department Available @" />
            @foreach ($department->locationDepartments as $locationDepartment)
                <div class="col-md-4">
                    @php
                        $departmentLink = route(
                            'app.location.locations.show',
                            ['location' => $locationDepartment->location->id]
                        );
                    @endphp

                    <x-show.field-text-link label="Department" :url="$departmentLink" labelIcon="columns-gap"
                        viewIcon="columns" linkLable="{{ $locationDepartment->location->slug }}" />
                </div>
            @endforeach
        </div>
    </section>
    <x-show.stamps :model="$department" />
</x-app-layout>
@php
    $links = [
        'Home' => '/',
        'Locations' => '/app/location/locations',
        'Show' => '#'
    ];
@endphp
<x-app-layout pageTitle="Location Details" :breadcrumbs="$links">

    <x-show.buttons>
        <x-show.back-button />
        {{-- <x-show.edit-button route="app.location.locations" :id="$location->id"
            can="app_location_locations_manage" /> --}}
        {{-- <x-show.delete-button route="app.location.locations" :id="$location->id"
            can="app_location_locations_manage" /> --}}
        <x-show.list-button route="app.location.locations" can="app_location_locations_read" label="Locations" />
    </x-show.buttons>

    <section class="section">
        <div class="row">
            <div class="col-md-6">
                <x-show.field label="Location" value="{{ $location->name }}" />
            </div>
            <div class="col-md-3">
                <x-show.field label="Short Name" value="{{ $location->slug }}" />
            </div>
            <div class="col-md-3">
                <x-show.field label="Company" value="{{ $location->company->slug }}" />
            </div>
            @php
                $countLabel = [
                    'coreDepartments' => count($location->coreDepartments) . " # Core Departments",
                    'subDepartments' => count($location->subDepartments) . " # Sub Departments",
                    'departments' => count($location->departments) . " # Departments",
                ]
            @endphp
            <x-show.hr-label :label="$countLabel['coreDepartments']" :triple=true />
            @foreach ($location->coreDepartments as $coreDepartment)
                <div class="col-md-6">
                    <x-show.field label="Core Departments" value="{{ $coreDepartment->name }}" />
                </div>
            @endforeach
            <x-show.hr-label :label="$countLabel['subDepartments']" :triple=true />
            @foreach ($location->subDepartments as $subDepartment)
                <div class="col-md-6">
                    <x-show.field label="Sub Departments" value="{{ $subDepartment->name }}" />
                </div>
            @endforeach
            <x-show.hr-label :label="$countLabel['departments']" :triple=true />
            @foreach ($location->departments as $department)
                <div class="col-md-6">
                    <x-show.field label="Department" value="{{ $department->name }}" />
                </div>
            @endforeach
            <x-show.hr-label label="E Urja Locations" :triple="true" />
            @foreach ($location->eurjaLocations as $eurjaLocation)
                <div class="col-md-6">
                    <x-show.field label="E-Urja Location" value="{{ $eurjaLocation->master }}" />
                </div>
            @endforeach
        </div>
    </section>
    <hr>
    <x-show.stamps :model="$location" />
</x-app-layout>
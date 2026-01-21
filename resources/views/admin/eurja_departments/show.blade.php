@php
    $links = [
        'Home' => '/',
        'EUrja Departments' => '/admin/eurja_departments',
        'Show' => '#'
    ];
@endphp
<x-app-layout pageTitle="Eurja Department Details" :breadcrumbs="$links">

    <x-show.buttons>
        <x-show.back-button />
        <x-show.list-button route="admin.eurja_departments" can="admin_eurja_departments_read" label="Eurja Departments" />
    </x-show.buttons>

    <section class="section">
        <div class="row">
            <div class="col-md-8">
                <x-show.field label="Master Name" value="{{ $eurjaDepartment->master }}" />
            </div>
            <div class="col-md-4">
                <x-show.field label="Code" value="{{ $eurjaDepartment->code }}" />
            </div>
            <div class="col-md-6">
                <x-show.field label="Eurja Department Name" value="{{ $eurjaDepartment->name }}" />
            </div>
            <div class="col-md-3">
                <x-show.field label="Location" value="{{ $eurjaDepartment->location_slug }}" />
            </div>
            <div class="col-md-3">
                <x-show.field label="Type" value="{{ config('constants.master.DEPARTMENT.TYPE.'.$eurjaDepartment->type) }}" />
            </div>
        </div>
    </section>
    <x-show.stamps :model="$eurjaDepartment" />
</x-app-layout>
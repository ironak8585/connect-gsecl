@php
    $links = [
        'Home' => '/',
        'Request' => '/emp/request/transfers',
        'Show' => '#'
    ];
@endphp
<x-emp-layout pageTitle="Transfer Details" :breadcrumbs="$links">

    <x-show.buttons>
        <x-show.back-button />
        <x-show.edit-button route="emp.request.transfers" :id="$transfer->id" can="emp_request_transfer_manage" />
        <x-show.delete-button route="emp.request.transfers" :id="$transfer->id" can="emp_request_transfer_manage" />
        <x-show.list-button route="emp.request.transfers" can="emp_request_transfer_read" label="Transfer Request" />
    </x-show.buttons>

    <section class="section">
        <div class="row">
            <div class="col-md-3">
                <x-show.field label="Employee No." value="{{ $transfer->employee_number }}" />
            </div>
            <div class="col-md-6">
                <x-show.field label="Name" value="{{ $transfer->employee->name }}" />
            </div>
            <div class="col-md-3">
                <x-show.field label="Designation" value="{{ $transfer->currentDesignation->name }}" />
            </div>
            <div class="col-md-6">
                <x-show.field label="Department" value="{{ $transfer->employee->department->name }}" />
            </div>
            <div class="col-md-6">
                <x-show.field label="Location" value="{{ $transfer->currentLocation->name }}" />
            </div>
            <hr>
            <div class="col-md-2">
                <x-show.field label="Priority" value="First" />
            </div>
            <div class="col-md-6">
                <x-show.field label="First Location" value="{{ $transfer->first_location->location->name }}" />
            </div>
            <div class="col-md-4">
                <x-show.field label="First Location Date"
                    value="{{ $transfer->first_location->request_date->format('d-m-Y') }}" />
            </div>
            <div class="col-md-2">
                <x-show.field label="Priority" value="Second" />
            </div>
            <div class="col-md-6">
                <x-show.field label="Second Location"
                    value="{{ $transfer->second_location?->location->name ?? '-- Not Opted --'}}" />
            </div>
            <div class="col-md-4">
                <x-show.field label="Seond Location Date"
                    value="{{ $transfer->second_location?->request_date->format('d-m-Y') ?? '-- Not Opted --' }}" />
            </div>
            <div class="col-md-2">
                <x-show.field label="Priority" value="Third" />
            </div>
            <div class="col-md-6">
                <x-show.field label="Third Location"
                    value="{{ $transfer->third_location?->location->name ?? '-- Not Opted --'}}" />
            </div>
            <div class="col-md-4">
                <x-show.field label="Third Location Date"
                    value="{{ $transfer->third_location?->request_date->format('d-m-Y') ?? '-- Not Opted --' }}" />
            </div>
        </div>
    </section>
    <x-show.stamps :model="$transfer" />
</x-emp-layout>
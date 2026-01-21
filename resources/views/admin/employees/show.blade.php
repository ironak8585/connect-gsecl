@php
    $links = [
        'Home' => '/',
        'Employees' => route('admin.employees.index'),
        'Details' => '#',
    ];
@endphp
<x-app-layout pageTitle="Employee Details" :breadcrumbs="$links">

    <x-show.buttons>
        <x-show.back-button />
        <x-show.list-button route="admin.employees" can="admin_employee_read" label="Employees" />
    </x-show.buttons>

    <section class="section">
        <div class="row">
            <div class="col-md-4">
                <x-show.field label="Name" value="{{ $employee->empname }}" />
            </div>
            <div class="col-md-2">
                <x-show.field label="Employee No." value="{{ $employee->employee_number }}" />
            </div>
            <div class="col-md-6">
                <x-show.field label="Location" value="{{ $employee->emplocation }}" />
            </div>
            <div class="col-md-4">
                <x-show.field label="Position" value="{{ $employee->empposition }}" />
            </div>
            <div class="col-md-3">
                <x-show.field label="Designation" value="{{ $employee->empdesig }}" />
            </div>
            <div class="col-md-5">
                <x-show.field label="Department" value="{{ $employee->empdepartment }}" />
            </div>
            <div class="col-md-5">
                <x-show.field label="Qualifications" value="{{ $employee->qualification }}" />
            </div>
            <div class="col-md-3">
                <x-show.field label="Caste" value="{{ $employee->empcaste }}" />
            </div>
            <div class="col-md-2">
                <x-show.field label="Class" value="{{ $employee->empclass }}" />
            </div>
            <div class="col-md-2">
                <x-show.field label="Gender" value="{{ $employee->empgender }}" />
            </div>
            <hr>
            <div class="col-md-2">
                <x-show.field label="Date of Joining" value="{{ $employee->dtjoin?->format('d-m-Y') }}" />
            </div>
            <div class="col-md-2">
                <x-show.field label="Date of Birth" value="{{ $employee->dtofbirth?->format('d-m-Y') }} | Age:{{ $employee->age }}" />
            </div>
            <div class="col-md-2">
                <x-show.field label="DOJ Current Cadre" value="{{ $employee->dtjoincurrentcadre?->format('d-m-Y') }}" />
            </div>
            <div class="col-md-2">
                <x-show.field label="DOJ Current Place" value="{{ $employee->dtjoincurrentplace?->format('d-m-Y') }}" />
            </div>
            <div class="col-md-2">
                <x-show.field label="Next Increment Date" value="{{ $employee->dtnextincrement?->format('d-m-Y') }}" />
            </div>
            <div class="col-md-2">
                <x-show.field label="Last Higher Grade Date" value="{{ $employee->dtlasthighergrade?->format('d-m-Y') }}" />
            </div>
            <div class="col-md-2">
                <x-show.field label="Basic" value="{{ $employee->basic }}" />
            </div>
            <div class="col-md-2">
                <x-show.field label="Years in Current Cadre" value="{{ $employee->yearscurrentcadre }}" />
            </div>
            <div class="col-md-2">
                <x-show.field label="Years in Current Place" value="{{ $employee->yearscurrentplace }}" />
            </div>
            <div class="col-md-2">
                <x-show.field label="Disability" value="{{ $employee->empdisabled }}" />
            </div>
            <div class="col-md-2">
                <x-show.field label="Category" value="{{ $employee->empcategory }}" />
            </div>
            <div class="col-md-2">
                <x-show.field label="Bloodgroup" value="{{ $employee->bloodgroup }}" />
            </div>
            <div class="col-md-3">
                <x-show.field label="Email" value="{{ $employee->email }}" />
            </div>
            <div class="col-md-2">
                <x-show.field label="Phone" value="{{ $employee->phone }}" />
            </div>
            <div class="col-md-3">
                <x-show.field label="Grade" value="{{ $employee->grade }}" />
            </div>
            <div class="col-md-2">
                <x-show.field label="Incharge Designation" value="{{ $employee->inchargeDesignation }}" />
            </div>
            <div class="col-md-2">
                <x-show.field label="Incharge Location" value="{{ $employee->inchargeLocation }}" />
            </div>
        </div>
    </section>
</x-app-layout>
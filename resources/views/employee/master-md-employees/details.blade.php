@php
    $links = [
        'Home' => '/',
        'Employees Dashboard' => route('employee.master-md-employees.index'),
        'Filter' => route('employee.master-md-employees.search'),
        'Details' => '#',
    ];
@endphp
<x-app-layout pageTitle="Employee Details" :breadcrumbs="$links">

    <x-show.buttons>
        <x-show.back-button />
        <x-show.list-button route="employee.master-md-employees" can="master_md_employee_read" label="Dashboard" />
        <x-show.link-button :url="route('employee.master-md-employees.search')" can="master_md_employee_read" label="Search Panel" />
    </x-show.buttons>

    <section class="section">
        <div class="row">
            <div class="col-md-4">
                <x-show.field label="Name" value="{{ $employee->name }}" />
            </div>
            <div class="col-md-2">
                <x-show.field label="Employee No." value="{{ $employee->new_emp_no }}" />
            </div>
            <div class="col-md-6">
                <x-show.field label="Position" value="{{ $employee->position }}" />
            </div>
            <div class="col-md-3">
                <x-show.field label="Core Department" value="{{ $employee->core_department }}" />
            </div>
            <div class="col-md-2">
                <x-show.field label="Class" value="{{ $employee->class }}" />
            </div>
            <div class="col-md-2">
                <x-show.field label="Gender" value="{{ $employee->gender }}" />
            </div>
            <div class="col-md-5">
                <x-show.field label="Qualifications" value="{{ $employee->qualification }}" />
            </div>
            <div class="col-md-3">
                <x-show.field label="Caste" value="{{ $employee->caste }}" />
            </div>
            <!-- <div class="col-md-3">
                <x-show.field label="Designation" value="{{ $employee->designation }}" />
            </div> -->
            <!-- <div class="col-md-2">
                <x-show.field label="Department" value="{{ $employee->department }}" />
            </div> -->
            <!-- <div class="col-md-3">
                <x-show.field label="Location" value="{{ $employee->organization }}" />
            </div> -->

            <div class="col-md-2">
                <x-show.field label="Date of Joining" value="{{ $employee->date_of_joining }}" />
            </div>
            <div class="col-md-2">
                <x-show.field label="DOJ Current Cadre" value="{{ $employee->doj_current_cadre }}" />
            </div>
            <div class="col-md-2">
                <x-show.field label="DOJ Current Place" value="{{ $employee->doj_current_place }}" />
            </div>
            <div class="col-md-3">
                <x-show.field label="Date of Birth" value="{{ $employee->dob }} | Age:{{ $employee->age }}" />
            </div>
            <div class="col-md-3">
                <x-show.field label="Email" value="{{ $employee->email }}" />
            </div>
            <div class="col-md-2">
                <x-show.field label="Phone" value="{{ $employee->phone_no }}" />
            </div>
            <div class="col-md-3">
                <x-show.field label="Grade" value="{{ $employee->grade }}" />
            </div>
            <div class="col-md-2">
                <x-show.field label="Basic" value="{{ $employee->basic }}" />
            </div>
            <div class="col-md-2">
                <!-- <a class="text-primary" data-bs-toggle="modal" data-bs-target="#subordinates-{{ $employee->id }}">{{ $subordinates->count() }}</a> -->
                <x-show.field label="Subordinates" :value="$subordinates->count()" data-bs-toggle="modal" data-bs-target="#subordinates-{{ $employee->id }}"/>
            </div>
            <hr>

            @if ($employee->supervisor_emp_no != null)
                <div class="col-md-6">
                    @php
                        $label = "Reporting Officer of $employee->new_emp_no";
                        $reportingOfficer = route('employee.master-md-employees.details', [
                            'employee_number' => $employee->supervisor_emp_no
                        ]);
                    @endphp

                    <x-show.field-text-link :label="$label" :url="$reportingOfficer"
                        linkLable="{{ $employee->supervisor_name }} - ({{ $employee->supervisor_emp_no }})" />
                </div>
            @else
                <div class="col-md-6">
                    <x-show.field label="Reporting Officer" value="No Reporting Officer Found !" />
                </div>
            @endif
            <!-- <div class="col-md-4">
                <x-show.field label="Caste" value="{{ $employee->caste }}" />
            </div> -->

            <!-- @dump($employee) -->

        </div>
    </section>
    <hr>
    <x-show.stamps :model="$employee" />

    <div class="modal fade" id="subordinates-{{ $employee->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Subordinates</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <x-show.key-value-field label="Employees" :value="$subordinates->pluck('name', 'new_emp_no')" icon="key"/>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
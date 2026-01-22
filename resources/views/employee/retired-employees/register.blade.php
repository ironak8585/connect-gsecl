@php
    $links = [
        'Home' => '/',
        'Register' => '/#',
    ];
@endphp
<x-web-layout pageTitle="Register as Patient" :breadcrumbs="$links">

    <section class="section">
        <form class="row g-3" action="{{ route('employee.retired-employees.register') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <!-- <div class="col-md-4">
                <x-form.select-input id="company" label="Company" name="company_id"
                    :options="$companies" :required="true" />
            </div> -->
            <div class="col-md-5">
                <x-form.select-input id="location" label="Location" name="location_id" :options="$locations"
                    :required="true" :isDummyRequired="true"/>
            </div>
            <div class="col-md-2">
                <x-form.number label="Employee No." name="employee_number"
                error="{{ $errors->first('employee_number') }}" :required="true" />
            </div>
            <div class="col-md-3">
                <x-form.date-input id="retirement_date" label="Retirement Date" name="retirement_date" :noPast="false"
                    :value="date('Y-m-d')" :required="true" />
            </div>
            <div class="col-md-2">
                <x-form.select-input id="gender" label="Gender" name="gender"
                    :options="config('constants.admin.EMPLOYEE.GENDER')" :required="true" />
            </div>
            <div class="col-md-5">
                <x-form.text label="Name" name="name" error="{{ $errors->first('name') }}" :required="true" />
            </div>
            <div class="col-md-4">
                <x-form.text-input type="email" label="Email" name="email" error="{{ $errors->first('email') }}"
                    required />
            </div>
            <div class="col-md-3">
                <x-form.number label="Mobile" name="contact" error="{{ $errors->first('contact') }}" required />
            </div>
            <div class="col-md-4">
                <x-form.file-input label="Last Medical Prescription" name="medical_report_file" error="{{ $errors->first('medical_report_file') }}" required />
            </div>
            <div class="col-md-4">
                <x-form.file-input label="Aadhar Card" name="uid_file" error="{{ $errors->first('uid_file') }}" required />
            </div>
            <div class="col-md-3">
                <x-form.number label="Aadhar No." name="uid" error="{{ $errors->first('uid') }}" required />
            </div>
            <x-show.hr-label label="Spouse Details" :triple=true />
            <div class="col-md-5">
                <x-form.text label="Spouse Name" name="spouse_name" error="{{ $errors->first('spouse_name') }}" :required="true" />
            </div>
            <div class="col-md-4">
                <x-form.text-input type="email" label="Spouse Email" name="spouse_email" error="{{ $errors->first('spouse_email') }}" />
            </div>
            <div class="col-md-3">
                <x-form.number label="Spouse Mobile" name="spouse_contact" error="{{ $errors->first('spouse_contact') }}" />
            </div>
            <div class="col-md-4">
                <x-form.file-input label="Aadhar Card" name="uid_file" error="{{ $errors->first('uid_file') }}" required />
            </div>
            <div class="col-md-3">
                <x-form.number label="Aadhar No." name="uid" error="{{ $errors->first('uid') }}" required />
            </div>
            <x-show.hr-label label="Dispensary Details" :triple=true />
            <div class="col-md-5">
                <x-form.select-input id="dispensary" label="Select Dispensary" name="dispensary_id" :options="$dispensaries"
                    :required="true" :isDummyRequired="true"/>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
        </form><!-- End Multi Columns Form -->
    </section>
</x-web-layout>
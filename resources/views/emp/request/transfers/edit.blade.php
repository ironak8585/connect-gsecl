@php
    $links = [
        'Home' => '/',
        'Transfers' => '/emp/request/transfers',
        'Add' => '#'
    ];
@endphp
<x-emp-layout pageTitle="Add Transfer" :breadcrumbs="$links">
    <x-show.buttons>
        <x-show.back-button />
        <x-show.list-button route="emp.request.transfers" can="emp_request_transfer_read" label="Transfers" />
    </x-show.buttons>

    <section class="section">

        <div class="row g-3">
            <div class="col-md-2">
                <x-show.field label="Employee No." value="{{ $transfer->employee->employee_number }}" />
            </div>
            <div class="col-md-6">
                <x-show.field label="Name" value="{{ $transfer->employee->name }}" />
            </div>
            <div class="col-md-4">
                <x-show.field label="Designation" value="{{ $transfer->employee->designation->name }}" />
            </div>
            <div class="col-md-6">
                <x-show.field label="Current Location" value="{{ $transfer->employee->location->name }}" />
            </div>
            <div class="col-md-6">
                <x-show.field label="Department" value="{{ $transfer->employee->department->name }}" />
            </div>
        </div>
        <hr>
        <form action="{{ route('emp.request.transfers.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <x-form.select-input label="First Preference" name="location_1" :options="$locations"
                        error="{{ $errors->first('location_1') }}" isDummyRequired="true" :required="true" :selected="$transfer->first_location?->id"/>
                </div>
                <div class="col-md-4">
                    <x-form.select-input label="Second Preference" name="location_2" :options="$locations"
                        error="{{ $errors->first('location_2') }}" isDummyRequired="true" :selected="$transfer->second_location?->id"/>
                </div>
                <div class="col-md-4">
                    <x-form.select-input label="Third Preference" name="location_3" :options="$locations"
                        error="{{ $errors->first('location_3') }}" isDummyRequired="true" :selected="$transfer->third_location?->id"/>
                </div>
                <div class="col-md-6">
                    <x-form.text-input label="Native Place" name="native_place" :required="false"
                        error="{{ $errors->first('native_place') }}" />
                </div>
                <div class="col-md-6">
                    <x-form.text-input label="Current Place" name="current_place" :required="false"
                        error="{{ $errors->first('current_place') }}" />
                </div>
                <div class="col-md-2">
                    <x-form.select-input label="Spouse Case" name="is_spouse_case"
                        :options="config('constants.master.YES_NO')" :required="true" :isDummyRequired="true"
                        :defaultSelected="0" error="{{ $errors->first('is_spouse_case') }}" />
                </div>
                <div class="col-md-3">
                    <x-form.number label="Spouse Employee No." name="spouse_employee_number"
                        error="{{ $errors->first('spouse_employee_number') }}" :required="false" />
                </div>
                <div class="col-md-4">
                    <x-form.select-input label="Spouse Employee Location" name="spouse_employee_location_id"
                        :options="$locations" :required="false" :isDummyRequired="true"
                        error="{{ $errors->first('spouse_employee_location_id') }}" />
                </div>
                <div class="col-md-12">
                    <x-form.textarea-input label="Reason" name="reason" maxlength="1000"
                        error="{{ $errors->first('Reason') }}" :required="false" />
                </div>
                <div class="col-md-12">
                    <x-form.text-input label="Remarks" name="remarks" :required="false"
                        error="{{ $errors->first('remarks') }}" />
                </div>
            </div>

            <hr>

            <div class="">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
        </form>
    </section>
</x-emp-layout>

@section('scripts')
    <script>
        $(document).ready(function () {

        });
    </script>
@endsection
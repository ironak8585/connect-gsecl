@php
    $links = [
        'Home' => '/',
        'Core Departments' => '/master/core_departments',
        'Add' => '#'
    ];
@endphp
<x-app-layout pageTitle="Add Core Departments" :breadcrumbs="$links">
    <x-show.buttons>
        <x-show.back-button />
        <x-show.list-button route="master.core_departments" can="master_core_departments_read" label="Core Departments" />
    </x-show.buttons>

    <section class="section">
        <form class="row g-3" action="{{ route('master.core_departments.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="col-md-9">
                <x-form.text label="Name" name="name" error="{{ $errors->first('name') }}"
                    :required="true" />
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
        </form><!-- End Multi Columns Form -->
    </section>
</x-app-layout>
@php
    $links = [
        'Home' => '/',
        'Import' => '#',
        'Master Employee' => '#'
    ];
@endphp
<x-app-layout pageTitle="Import Master Employee" :breadcrumbs="$links">
    <!-- Loader Overlay -->
    <x-show.loader message="Data Importing is in Process... Please Wait !" route="admin.master-employees.process"></x-show.loader>

    <x-show.buttons>
        <!-- <x-show.back-button /> -->
        <!-- <x-show.list-button route="admin.permissions" can="admin_permissions_read" label="Permissions" /> -->
    </x-show.buttons>

    <section class="section">
        <div class="row mb-5">
            <div class="col-md-12 text-center">
                <h1 class="text-danger fw-bold mb-3">
                    Clear Existing Employees Data. Once Data is Cleared, Cannot Be Retrieved!
                </h1>
                <h2 class="text-danger fw-bold mb-3">
                    Other Data like Power Stations, Designations, Departments etc. will also be deleted !
                </h2>
                <form action="{{ route('admin.master-employees.clear') }}" method="GET"
                    onsubmit="return confirm('Are you sure you want to clear all employees and related data? This action cannot be undone!');">
                    <x-form.submit label="Clear Existing Employees Data" class="btn btn-danger" />
                </form>
            </div>
        </div>
    </section>

    <section class="section">
        <form action="{{ route('admin.master-employees.process') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <x-form.file-input label="Master Excel File" name="excel_file" required
                error="{{ $errors->first('excel_file') }}" />

            <x-form.submit label="Import" class="btn btn-primary" />

            <!-- download sample file buttons -->
            <a href="{{ asset('assets/documents/import/MasterToImport.csv') }}" class="btn btn-secondary">
                Download Sample File
            </a>

        </form>
    </section>
</x-app-layout>
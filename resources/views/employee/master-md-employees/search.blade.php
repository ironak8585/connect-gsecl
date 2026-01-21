@php
    $links = [
        'Home' => '/',
        'Employees Dashboard' => route('employee.master-md-employees.index'),
        'Filter' => '#',
    ];
@endphp

<x-app-layout pageTitle="Master Employees" :breadcrumbs="$links">

    <section class="section dashboard">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Filter Panel</h5>

                        <!-- Multi Columns Form -->
                        <form id="filterForm" class="row g-3" method="GET"
                            action="{{ route('employee.master-md-employees.filter') }}">

                            <div class="col-md-3">
                                <x-form.select-input name="organization" :options="$organizations" id="organizations"
                                    label="Power Station" :isDummyRequired="true" />
                            </div>
                            <div class="col-md-3">
                                <x-form.select-input name="core_department" :options="$coreDepartments"
                                    id="core_department" label="Core Department" :isDummyRequired="true" />
                            </div>
                            <div class="col-md-3">
                                <x-form.select-input name="designation" :options="$designationsList" id="designation"
                                    label="Designation" :isDummyRequired="true" />
                            </div>
                            <div class="col-md-2">
                                <x-form.select-input name="employee_type" :options="$employeeTypes" id="employee_type"
                                    label="Employee Type" :isDummyRequired="true" />
                            </div>
                            <div class="col-md-1">
                                <x-form.select-input name="class" :options="$employeeClasses" id="class" label="Class"
                                    :isDummyRequired="true" />
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Search</button>
                                <button type="reset" class="btn btn-secondary">Clear</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Search Results</h5>

                        <div id="search-results">
                            <table id="employeeTable" class="table">
                                <thead>
                                    <tr>
                                        <th>Sr. No</th>
                                        <th>Emp. No.</th>
                                        <th>Name</th>
                                        <th>Organization</th>
                                        <th>Core Department</th>
                                        <th>Designation</th>
                                        <th>Class</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    @push('scripts')
        <script>
            $(document).ready(function () {

                var table = $('#employeeTable').DataTable({
                    processing: true,
                    serverSide: false,
                    ajax: {
                        url: $('#filterForm').attr('action'),
                        dataSrc: 'data',
                        data: function (d) {
                            var formData = $('#filterForm').serializeArray();
                            formData.forEach(function (item) {
                                d[item.name] = item.value;
                            });
                        }
                    },
                    columns: [
                        {
                            data: null,
                            render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'new_emp_no',
                            render: function (data, type, row, meta) {
                                // Get the base URL from Laravel
                                const baseUrl = "{{ route('employee.master-md-employees.details', ['employee_number' => 'EMP_NO']) }}";
                                const url = baseUrl.replace('EMP_NO', data);
                                return `<a href="${url}" target="_self">${data}</a>`;
                            }
                        },
                        { data: 'name' },
                        { data: 'organization' },
                        { data: 'core_department' },
                        { data: 'designation' },
                        { data: 'class' }
                    ]
                });

                $('#filterForm').on('submit', function (e) {
                    e.preventDefault();
                    table.ajax.reload();
                });

                $('#filterForm').on('reset', function () {
                    setTimeout(function () {
                        table.ajax.reload();
                    }, 100);
                });
            });
        </script>

    @endpush

</x-app-layout>
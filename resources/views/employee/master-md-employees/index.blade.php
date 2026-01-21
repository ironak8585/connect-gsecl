@php
    $links = [
        'Home' => '/',
        'Master Employees' => '#',
    ];
@endphp

<x-app-layout pageTitle="Master Employees" :breadcrumbs="$links">

    <section class="section dashboard">
        <div class="d-flex justify-content-end mb-2">
            <a href="{{ route('employee.master-md-employees.search') }}" type="button" class="btn btn-primary">
                <i class="bi bi-funnel me-1"></i> Filter Panel
            </a>
        </div>
        <div class="row">
            <!-- Power Stations Card -->
            <div class="col-xxl-3 col-md-6">
                <div class="card info-card sales-card">

                    <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Power Stations</h6>
                            </li>
                            @foreach ($organizations as $station)
                                <li><a class="dropdown-item">{{ $station }}</a></li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="card-body">
                        <h5 class="card-title">Power Stations</h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="ri-building-2-fill"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $counts['organization_count'] }}</h6>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Departments Card -->
            <div class="col-xxl-3 col-md-6">
                <div class="card info-card revenue-card">

                    <div class="card-body">
                        <h5 class="card-title">Core Department</h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="ri-collage-fill"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $counts['core_department_count'] }}</h6>
                                <span class="text-success small pt-1 fw-bold">{{ $counts['department_count'] }}
                                    All Departments</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Designation Card -->
            <div class="col-xxl-3 col-md-6">
                <div class="card info-card customers-card">

                    <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Class</h6>
                            </li>
                            @foreach ($classWiseDesignationCounts as $class => $data)
                                <li><a class="dropdown-item">Class {{ $data['class'] }} :
                                        {{ $data['designation_count'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="card-body">
                        <h5 class="card-title">Designations</h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-person-badge-fill"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $counts['designation_count'] }}</h6>
                                <span class="text-success small pt-1 fw-bold">Class (I :
                                    {{ $classWiseDesignationCounts[1]['designation_count'] ?? 0 }})</span>
                                <span class="text-muted small pt-2 ps-1">(II :
                                    {{ $classWiseDesignationCounts[2]['designation_count'] ?? 0 }})</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Employees Card -->
            <div class="col-xxl-3 col-md-6">
                <div class="card info-card sales-card">

                    <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Class</h6>
                            </li>
                            <li><a class="dropdown-item">I : {{ $counts['class_I_count'] ?? 0 }}</a></li>
                            <li><a class="dropdown-item">II : {{ $counts['class_II_count'] ?? 0 }}</a></li>
                            <li><a class="dropdown-item">III : {{ $counts['class_III_count'] ?? 0 }}</a></li>
                            <li><a class="dropdown-item">IV : {{ $counts['class_IV_count'] ?? 0 }}</a></li>
                            <li class="dropdown-header text-start">
                                <h6>Gender</h6>
                            </li>
                            <li><a class="dropdown-item">Male : {{ $counts['male_count'] }}</a></li>
                            <li><a class="dropdown-item">Female : {{ $counts['female_count'] }}</a></li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <h5 class="card-title">Employees</h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $counts['total_employees'] }}</h6>
                                <span class="text-success small pt-1 fw-bold">T :
                                    {{ $counts['tech_count'] }}</span>
                                <span class="text-muted small pt-2 ps-1">NT :
                                    {{ $counts['non_tech_count'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Power Station Class Wise Employees</h5>

                        <!-- Column Chart -->
                        <div id="columnChart"></div>

                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                let categories = @json($orgWiseCountsforCharts->pluck('short_name'));
                                let classI = @json($orgWiseCountsforCharts->pluck('class_I_count'));
                                let classII = @json($orgWiseCountsforCharts->pluck('class_II_count'));
                                let classIII = @json($orgWiseCountsforCharts->pluck('class_III_count'));
                                let classIV = @json($orgWiseCountsforCharts->pluck('class_IV_count'));

                                new ApexCharts(document.querySelector("#columnChart"), {
                                    series: [
                                        { name: 'Class I', data: classI },
                                        { name: 'Class II', data: classII },
                                        { name: 'Class III', data: classIII },
                                        { name: 'Class IV', data: classIV }
                                    ],
                                    chart: {
                                        type: 'bar',
                                        height: 400
                                    },
                                    plotOptions: {
                                        bar: {
                                            horizontal: false,
                                            columnWidth: '55%',
                                            endingShape: 'rounded'
                                        }
                                    },
                                    dataLabels: {
                                        enabled: false
                                    },
                                    stroke: {
                                        show: true,
                                        width: 2,
                                        colors: ['transparent']
                                    },
                                    xaxis: {
                                        categories: categories
                                    },
                                    yaxis: {
                                        title: {
                                            text: 'Employees Count'
                                        }
                                    },
                                    fill: {
                                        opacity: 1
                                    },
                                    tooltip: {
                                        y: {
                                            formatter: function (val) {
                                                return val + " employees";
                                            }
                                        }
                                    }
                                }).render();
                            });
                        </script>

                        <!-- End Column Chart -->

                    </div>
                </div>
            </div>

        </div>

    </section>

</x-app-layout>
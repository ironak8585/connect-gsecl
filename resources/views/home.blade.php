<x-web-layout pageTitle="Welcome">

  <section class="section dashboard">
    <div class="row">

      <div class="col-lg-12">
        <div class="row">

          <!-- Power Stations Card -->
          <div class="col-xxl-3 col-md-4">
            <div class="card info-card sales-card">

              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Power Stations</h6>
                  </li>
                  @foreach ($locations as $station)
            <li><a class="dropdown-item">{{ $station->name }} ( {{ $station->slug }} )</a></li>
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
                    <h6>{{ $locations->count() }}</h6>
                  </div>
                </div>
              </div>

            </div>
          </div><!-- End Sales Card -->

          <!-- Dispensaries Card -->
          <div class="col-xxl-3 col-md-4">
            <div class="card info-card revenue-card">

              <div class="card-body">
                <h5 class="card-title">Dispensaries</h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="ri-collage-fill"></i>
                  </div>
                  <div class="ps-3">
                    <h6>55</h6>
                  </div>
                </div>
              </div>

            </div>
          </div>

          <!-- Employees Card -->
          <div class="col-xxl-3 col-md-4">
            <div class="card info-card sales-card">
              <div class="card-body">
                <h5 class="card-title">Employees</h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people-fill"></i>
                  </div>
                  <div class="ps-3">
                    <h6>{{ $employees->count() }}</h6>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Circulars -->
          <div class="col-12">
            <div class="card recent-sales overflow-auto">

              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Categories</h6>
                  </li>
                  @foreach ($circularCategories as $id => $circularCategory)
                    <li><a class="dropdown-item" href="#">{{$circularCategory}}</a></li>
                  @endforeach
              </div>

              <div class="card-body">
                <h5 class="card-title">Dispensaries <span>| <a href="{{ route('web.content.circulars.index') }}"><i
                        class="bi bi-arrow-up-right-square"></i> All</a></span></h5>

                <table class="table table-borderless datatable">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Name</th>
                      <th scope="col">Location</th>
                      <th scope="col" class="text-end">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($circulars as $circular)
                      <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td><?= $circular->title ?></td>
                        <td><?= $circular->published_at->format('d-M-Y') ?></td>
                        <td><x-form.action-buttons :id="$circular->id" :model="$circular" route="web.content.circulars"
                          :delete="false" :archive="false" :restore="false" :edit="false" /></td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>

              </div>

            </div>
          </div><!-- End Recent Sales -->

          <!-- Reports -->
          <div class="col-12">
            <div class="card">

              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                  </li>

                  <li><a class="dropdown-item" href="#">Today</a></li>
                  <li><a class="dropdown-item" href="#">This Month</a></li>
                  <li><a class="dropdown-item" href="#">This Year</a></li>
                </ul>
              </div>

              <div class="card-body">
                <h5 class="card-title">Enrollment <span>/Today</span></h5>

                <!-- Line Chart -->
                <div id="reportsChart"></div>

                <script>
                  document.addEventListener("DOMContentLoaded", () => {
                    new ApexCharts(document.querySelector("#reportsChart"), {
                      series: [{
                        name: 'Registered',
                        data: [31, 40, 28, 51, 42, 82, 56, 12],
                      }, {
                        name: 'Verified',
                        data: [11, 32, 45, 32, 34, 52, 41, 13]
                      }, {
                        name: 'Confirmed',
                        data: [15, 11, 32, 18, 9, 24, 11, 14]
                      }],
                      chart: {
                        height: 350,
                        type: 'area',
                        toolbar: {
                          show: false
                        },
                      },
                      markers: {
                        size: 4
                      },
                      colors: ['#4154f1', '#2eca6a', '#ff771d'],
                      fill: {
                        type: "gradient",
                        gradient: {
                          shadeIntensity: 1,
                          opacityFrom: 0.3,
                          opacityTo: 0.4,
                          stops: [0, 90, 100]
                        }
                      },
                      dataLabels: {
                        enabled: false
                      },
                      stroke: {
                        curve: 'smooth',
                        width: 2
                      },
                      xaxis: {
                        type: 'datetime',
                        categories: ["2025-06-19T00:00:00.000Z", "2025-07-19T01:30:00.000Z", "2025-08-19T02:30:00.000Z", "2025-09-19T03:30:00.000Z", "2025-10-19T04:30:00.000Z", "2025-11-19T05:30:00.000Z", "2025-12-19T06:30:00.000Z", "2026-01-20T22:05:00.000Z"]
                      },
                      tooltip: {
                        x: {
                          format: 'dd/MM/yy HH:mm'
                        },
                      }
                    }).render();
                  });
                </script>
                <!-- End Line Chart -->

              </div>

            </div>
          </div><!-- End Reports -->

        </div>
      </div><!-- End Left side columns -->

    </div>
  </section>
</x-web-layout>
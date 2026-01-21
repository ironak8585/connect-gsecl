@php
    $links = [
        'Home' => '/',
        'Request' => '/',
        'Transfers' => '#',
    ];
    $fields = [
        'employee_number' => ['number', 'Employee Number'],
        'name' => ['text', 'Name'],
    ]
@endphp
<x-emp-layout pageTitle="Transfers" :breadcrumbs="$links">
    <section class="section">

        <x-show.buttons>
            <x-system.filter-panel :fields="$fields" :filters="$filters" route="emp.request.transfers.index">
            </x-system.filter-panel>
        </x-show.buttons>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="bi bi-info-circle me-1"></i>
            To place a new transfer request please login using your eUrja Credentials ! <a href="{{ route('emp.request.transfers.create') }}">Click Here <i class="bi bi-arrow-up-right-square"></i>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <!-- Table with stripped rows -->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Employee No.</th>
                    <th scope="col">Name</th>
                    <th scope="col">Current Location</th>
                    <th scope="col">First preference</th>
                    <th scope="col">Second preference</th>
                    <th scope="col">Third preference</th>
                    <th scope="col">Req. Created @</th>
                    <th scope="col" class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $record)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <th scope="row">{{ $record->employee_number }}</th>
                        <th scope="row">{{ $record->employee->name }}</th>
                        <th scope="row">{{ $record->currentLocation->slug }}</th>
                        <td>
                            @if($record->first_location)
                                {{ $record->first_location->location->slug }}
                                ({{ $record->first_location->request_date->format('d-m-Y') }})
                            @else
                                <span class="text-muted">Not Opted</span>
                            @endif
                        </td>
                        <td>
                            @if($record->second_location)
                                {{ $record->second_location->location->slug }}
                                ({{ $record->second_location->request_date->format('d-m-Y') }})
                            @else
                                <span class="text-muted">Not Opted</span>
                            @endif
                        </td>

                        <td>
                            @if($record->third_location)
                                {{ $record->third_location->location->slug }}
                                ({{ $record->third_location->request_date->format('d-m-Y') }})
                            @else
                                <span class="text-muted">Not Opted</span>
                            @endif
                        </td>

                        <td>{{ $record->created_at->format('d-m-Y') }}</td>
                        <td class="text-end">
                            <x-form.action-buttons :id="$record->id" :model="$record" route="web.request.transfers"
                                :delete="false" :archive="false" :edit="false" :restore="false" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <x-form.pagination-input :records="$records" />
    </section>
    </x-app-layout>
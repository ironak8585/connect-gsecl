@php
    $links = [
        'Home' => '/',
        'Location' => '#',
    ];
    $fields = [
        'name' => ['text', 'Name'],
    ]
@endphp
<x-app-layout pageTitle="Locations" :breadcrumbs="$links">
    <section class="section">

        <x-show.buttons>
            <x-system.filter-panel :fields="$fields" :filters="$filters" route="app.location.locations.index">
            </x-system.filter-panel>
        </x-show.buttons>

        <!-- Table with stripped rows -->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Location</th>
                    <th scope="col">Short Name</th>
                    <th scope="col">Company</th>
                    <th scope="col">Eurja Location #</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $record)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $record->name }}</td>
                        <td>{{ $record->slug }}</td>
                        <td>{{ $record->company->slug }}</td>
                        <td>{{ count($record->eurjaLocations) }}</td>
                        <td>
                            <x-form.action-buttons :id="$record->id" :model="$record" route="app.location.locations"
                                :delete="false" :archive="false" :restore="false" :edit="false" read="app_location_locations_read"
                                can="app_location_locations_manage" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <x-form.pagination-input :records="$records" />
    </section>
</x-app-layout>
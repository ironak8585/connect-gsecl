@php
    $links = [
        'Home' => '/',
        'Request' => '#',
        'Transfers' => '#',
    ];
    $fields = [
        'employee_number' => ['number', 'Employee Number'],
        'name' => ['text', 'Name'],
    ]
@endphp
<x-app-layout pageTitle="Transfers" :breadcrumbs="$links">
    <section class="section">

        <x-show.buttons>
            <x-show.create-button route="app.request.transfers" can="app_content_circular_manage" />
            <x-system.filter-panel :fields="$fields" :filters="$filters" route="app.request.transfers.index">
            </x-system.filter-panel>
        </x-show.buttons>

        <!-- Table with stripped rows -->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Request #</th>
                    <th scope="col">Location 1</th>
                    <th scope="col">Location 2</th>
                    <th scope="col">Location 3</th>
                    <th scope="col">Published @</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $record)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $record->circular_number }}</td>
                        <td>{{ $record->title }}</td>
                        <td>{{ $record->status }}</td>
                        <td>{{ $record->visibility }}</td>
                        <td>{{ $record->published_at }}</td>
                        <td>
                            <x-form.action-buttons :id="$record->id" :model="$record" route="app.request.transfers"
                                :delete="true" :archive="false" :restore="true" read="app_request_transfer_read"
                                can="app_request_transfer_manage" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <x-form.pagination-input :records="$records" />
    </section>
</x-app-layout>
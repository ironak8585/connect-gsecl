@php
    $links = [
        'Home' => '/',
        'Content' => '#',
    ];
    $fields = [
        'name' => ['text', 'Name'],
        'description' => ['text', 'Description'],
        'guard_name' => ['text', 'Guard Name']
    ]
@endphp
<x-app-layout pageTitle="Circulars" :breadcrumbs="$links">
    <section class="section">

        <x-show.buttons>
            <x-show.create-button route="app.content.circulars" can="app_content_circular_manage" />
            <x-system.filter-panel :fields="$fields" :filters="$filters" route="app.content.circulars.index">
            </x-system.filter-panel>
        </x-show.buttons>

        <!-- Table with stripped rows -->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Circular #</th>
                    <th scope="col">Title</th>
                    <th scope="col">Status</th>
                    <th scope="col">Visibility</th>
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
                            <x-form.action-buttons :id="$record->id" :model="$record" route="app.content.circulars"
                                :delete="true" :archive="false" :restore="true" read="app_content_circular_read"
                                can="app_content_circular_manage" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <x-form.pagination-input :records="$records" />
    </section>
</x-app-layout>
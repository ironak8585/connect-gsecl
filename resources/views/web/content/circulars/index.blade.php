@php
    $links = [
        'Home' => '/',
        'Content' => '#',
        'Circulars' => '#',
    ];
    $fields = [
        'title' => ['text', 'Title'],
        'description' => ['text', 'Description'],
    ];
@endphp
<x-web-layout pageTitle="Circulars" :breadcrumbs="$links">
    <section class="section">

        <x-show.buttons>
            <x-system.filter-panel :fields="$fields" :filters="$filters" route="web.content.circulars.index">
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
                            <x-show.action-buttons :id="$record->id" :model="$record" route="web.content.circulars" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <x-form.pagination-input :records="$records" />
    </section>
</x-web-layout>
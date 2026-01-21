@php
    $links = [
        'Home' => '/',
        'Circulars' => '/app/content/circulars',
        'Show' => '#'
    ];
@endphp
<x-app-layout pageTitle="Circular Details" :breadcrumbs="$links">

    <x-show.buttons>
        <x-show.back-button />
        <x-show.edit-button route="app.content.circulars" :id="$circular->id" can="app_content_circular_manage" />
        <x-show.delete-button route="app.content.circulars" :id="$circular->id" can="app_content_circular_manage" />
        <x-show.list-button route="app.content.circulars" can="app_content_circular_read" label="circulars" />
    </x-show.buttons>

    <section class="section">
        <div class="row">
            <div class="col-md-3">
                <x-show.field label="Circular No." value="{{ $circular->circular_number }}" />
            </div>
            <div class="col-md-9">
                <x-show.field label="Title" value="{{ $circular->title }}" />
            </div>
            <div class="col-md-3">
                <x-show.field label="Circular Category" value="{{ $circular->category->name }}" />
            </div>
            <div class="col-md-9">
                <x-show.field label="Description" value="{{ $circular->description }}" />
            </div>
            <div class="col-md-3">
                <x-show.field label="Status" value="{{ $circular->status }}" />
            </div>
            <div class="col-md-3">
                <x-show.field label="Visibility" value="{{ $circular->visibility }}" />
            </div>
            <div class="col-md-3">
                <x-show.field-link label="Attachment" target="_blank" url="{{ $circular->attachment_url }}" />
            </div>
        </div>
    </section>
    <x-show.stamps :model="$circular" />
</x-app-layout>
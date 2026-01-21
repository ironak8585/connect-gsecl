@php
    $links = [
        'Home' => '/',
        'Circulars' => '/app/content/circulars',
        'Edit' => '#'
    ];
@endphp
<x-app-layout pageTitle="Edit Circular" :breadcrumbs="$links">
    <x-show.buttons>
        <x-show.back-button />
        <x-show.create-button route="app.content.circulars" can="app_content_circular_manage" label="Create New" />
        <x-show.show-button route="app.content.circulars" :id="$circular->id" can="app_content_circular_read" />
        <x-show.delete-button route="app.content.circulars" :id="$circular->id" can="app_content_circular_manage" />
        <x-show.list-button route="app.content.circulars" can="app_content_circular_read" label="Circulars" />
    </x-show.buttons>

    <section class="section">
        <form class="row g-3" action="{{ route('app.content.circulars.update', $circular->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-md-2">
                <x-form.select-input id="category_id" label="Category" name="category_id" :options="$categories"
                    :required="true" :selected="$circular->category_id" />
            </div>
            <div class="col-md-4">
                <x-form.text label="Circular No." name="circular_number" error="{{ $errors->first('circular_number') }}"
                    :value="old('circular_number', $circular->circular_number)" :required="true" />
            </div>
            <div class="col-md-6">
                <x-form.text label="Title" name="title" error="{{ $errors->first('title') }}" :required="true"
                    :value="old('title', $circular->title)" />
            </div>
            <div class="col-md-12">
                <x-form.textarea-input label="Description" name="description"
                    error="{{ $errors->first('description') }}" :value="old('description', $circular->description)"
                    :required="false" />
            </div>
            <div class="col-md-6">
                <x-form.file-input label="Attachment" name="attachment" :value="$circular->attachment_url"
                    error="{{ $errors->first('attachment') }}" />
            </div>
            <div class="col-md-2">
                <x-form.select-input id="status" label="Status" name="status"
                    :options="config('constants.master.CIRCULAR_STATUS')" :required="true"
                    :selected="$circular->status" />
            </div>
            <div class="col-md-2">
                <x-form.select-input id="visibility" label="Visibility" name="visibility"
                    :options="config('constants.master.CIRCULAR_VISIBILITY')" :required="true"
                    :selected="$circular->visibility" />
            </div>
            <div class="col-md-2">
                <x-form.date-input id="issue_date" label="Issue Date" name="issue_date"
                    :value="$circular->issue_date->format('Y-m-d')" disabled />
            </div>
            <div class="col-md-2">
                <x-form.datetime-input id="published_at" label="Published At" name="published_at" 
                    :value="$circular->published_at->format('Y-m-d\TH:i')" disabled />
            </div>
            <div class="col-md-2">
                <x-form.date-input id="effective_date" label="Effective Date" name="effective_date"
                    :value="$circular->effective_date->format('Y-m-d')" :required="false" />
            </div>
            <div class="col-md-2">
                <x-form.date-input id="expiry_date" label="Expiry Date" name="expiry_date"
                    :required="false" :value="$circular->expiry_date?->format('Y-m-d')" />
            </div>
            <div class="col-md-2">
                <x-form.select-input id="is_active" label="Active" name="is_active"
                    :options="config('constants.master.YES_NO')" :required="true" :selected="$circular->is_active" />
            </div>
            <div class="text-left">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
        </form><!-- End Multi Columns Form -->
    </section>
</x-app-layout>
@php
    $links = [
        'Home' => '/',
        'Circulars' => '/app/content/circulars',
        'Add' => '#'
    ];
@endphp
<x-app-layout pageTitle="Add Circular" :breadcrumbs="$links">
    <x-show.buttons>
        <x-show.back-button />
        <x-show.list-button route="app.content.circulars" can="app_content_circular_read" label="Circulars" />
    </x-show.buttons>

    <section class="section">
        <form class="row g-3" action="{{ route('app.content.circulars.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="col-md-2">
                <x-form.select-input id="category_id" label="Category" name="category_id" :options="$categories"
                    :required="true" />
            </div>
            <div class="col-md-4">
                <x-form.text label="Circular No." name="circular_number" error="{{ $errors->first('circular_number') }}"
                    :required="true" />
            </div>
            <div class="col-md-6">
                <x-form.text label="Title" name="title" error="{{ $errors->first('title') }}" :required="true" />
            </div>
            <div class="col-md-12">
                <x-form.textarea-input label="Description" name="description"
                    error="{{ $errors->first('description') }}" :required="false" />
            </div>
            <div class="col-md-6">
                <x-form.file-input label="Attachment" name="attachment" error="{{ $errors->first('attachment') }}"
                    required />
            </div>
            <div class="col-md-2">
                <x-form.select-input id="status" label="Status" name="status"
                    :options="config('constants.master.CIRCULAR_STATUS')" :required="true" />
            </div>
            <div class="col-md-2">
                <x-form.select-input id="visibility" label="Visibility" name="visibility"
                    :options="config('constants.master.CIRCULAR_VISIBILITY')" :required="true" />
            </div>
            <div class="col-md-2">
                <x-form.date-input id="issue_date" label="Issue Date" name="issue_date" :noPast="true"
                    :value="date('Y-m-d')" :required="true" />
            </div>
            <div class="col-md-2">
                <x-form.datetime-input id="published_at" label="Published At" name="published_at" :value="now()->format('Y-m-d\TH:i')" :required="true" />
            </div>
            <div class="col-md-2">
                <x-form.date-input id="effective_date" label="Effective Date" name="effective_date" :value="date('Y-m-d')" :required="false" />
            </div>
            <div class="col-md-2">
                <x-form.date-input id="expiry_date" label="Expiry Date" name="expiry_date" :noPast="true"
                    :required="false" />
            </div>
            <div class="col-md-2">
                <x-form.select-input id="is_active" label="Is Active" name="is_active"
                    :options="config('constants.master.YES_NO')" :required="true" />
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
        </form><!-- End Multi Columns Form -->
    </section>
</x-app-layout>
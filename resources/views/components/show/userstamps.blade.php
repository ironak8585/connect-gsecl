@props(['model'])

@php
    $createdBy = $model->creator->name ?? null;
    $updatedBy = $model->editor->name ?? null;
    $deletedBy = $model->deleter->name ?? null;
@endphp

<div class="row">
    @if ($createdBy)
        <div class="col-md-3">
            <x-show.field label="Created By" :value="$createdBy" icon="person-plus-fill" />
        </div>
    @endif

    @if ($updatedBy)
        <div class="col-md-3">
            <x-show.field label="Updated By" :value="$updatedBy" icon="person-check-fill" />
        </div>
    @endif

    @if ($deletedBy)
        <div class="col-md-3">
            <x-show.field label="Deleted By" :value="$deletedBy" icon="person-dash-fill" />
        </div>
    @endif
</div>
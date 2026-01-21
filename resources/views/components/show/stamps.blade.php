@props(['model'])

@php
    $createdAt = $model->created_at?->format('d/m/Y H:i');
    $updatedAt = $model->updated_at?->format('d/m/Y H:i');
    $deletedAt = $model->deleted_at?->format('d/m/Y H:i');

    $createdBy = $model->creator->name ?? null;
    $updatedBy = $model->editor->name ?? null;
    $deletedBy = $model->deleter->name ?? null;
@endphp

<div class="row">
    @if ($createdAt)
        <div class="col-md-3">
            <x-show.field label="Created At" :value="$createdAt" icon="bi-solid bi-calendar-plus" />
        </div>
    @endif

    @if ($updatedAt)
        <div class="col-md-3">
            <x-show.field label="Updated At" :value="$updatedAt" icon="bi-solid bi-calendar-check" />
        </div>
    @endif

    @if ($deletedAt)
        <div class="col-md-3">
            <x-show.field label="Deleted At" :value="$deletedAt" icon="bi-solid bi-calendar-xmark" />
        </div>
    @endif

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
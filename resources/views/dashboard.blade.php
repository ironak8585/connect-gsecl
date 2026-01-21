@php
    $links = [
        'Home' => '/dashboard',
        'Dashboard' => '#',
    ];
@endphp
<x-app-layout pageTitle="Dashboard" :breadcrumbs="$links">
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-1"></i>
        You are successfully logged in !!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</x-app-layout>
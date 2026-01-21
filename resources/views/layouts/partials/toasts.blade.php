{{-- Toast Messages --}}
@if ($errors->any())
    @foreach ($errors->all() as $error)
        <x-show.toast type="error" :message="$error" />
    @endforeach
@endif

@if (session('success'))
    <x-show.toast type="success" :message="session('success')" />
@endif

@if (session('error'))
    <x-show.toast type="error" :message="session('error')" />
@endif

@if (session('warning'))
    <x-show.toast type="warning" :message="session('warning')" />
@endif

{{-- Auto-show Toasts --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toastElList = Array.from(document.querySelectorAll('.toast'));
        toastElList.forEach(toastEl => {
            new bootstrap.Toast(toastEl, {
                delay: 4000,
                autohide: true
            }).show();
        });
    });
</script>
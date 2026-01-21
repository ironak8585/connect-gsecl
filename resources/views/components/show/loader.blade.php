@props([
    'route' => null,
    'message' => "Processing... Please wait"
])

<div id="loader-overlay"
     class="position-fixed top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center bg-dark bg-opacity-75 d-none"
     style="z-index: 1050;">
    <div class="spinner-grow text-light" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
    <span class="text-white ms-3 fs-5 fw-bold">{{ $message }}</span>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const loader = document.getElementById("loader-overlay");

        // Show loader on form submission (POST, PUT, etc.)
        const importForm = document.querySelector('form[action="{{ $route ? route($route) : '' }}"]');
        if (importForm) {
            importForm.addEventListener("submit", function () {
                loader.classList.remove("d-none");
                document.body.style.overflow = "hidden";
            });
        }

        // Show loader on GET navigation clicks
        const links = document.querySelectorAll(`a[href="{{ $route ? route($route) : '' }}"]`);
        links.forEach(link => {
            link.addEventListener("click", function (e) {
                loader.classList.remove("d-none");
                document.body.style.overflow = "hidden";
            });
        });
    });
</script>

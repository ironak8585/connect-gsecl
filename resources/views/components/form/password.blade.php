@props(['name', 'label' => null, 'noLabel' => false, 'required' => false])

@php
    $labelText = $label ?? ucwords(str_replace('_', ' ', $name));
    $id = strtolower(str_replace('_', '-', $name));
@endphp

@if (!$noLabel)
    <label for="{{ $id }}" class="form-label fw-semibold">
        {{ $labelText }}
        @if($required)
            <span class="text-danger">*</span>
        @endif
    </label>
@endif

<div class="input-group">
    <input type="password" class="form-control" name="{{ $name }}" id="{{ $id }}" required>

    <span class="input-group-text" onclick="togglePassword('{{ $id }}', this)" style="cursor: pointer;">
        <i class="bi bi-eye-slash" id="icon-{{ $id }}"></i>
    </span>
</div>

<div class="invalid-feedback">Enter {{ $labelText }}!</div>

@once
    <script>
        function togglePassword(id, el) {
            const input = document.getElementById(id);
            const icon = el.querySelector('i');

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("bi-eye-slash");
                icon.classList.add("bi-eye");
            } else {
                input.type = "password";
                icon.classList.remove("bi-eye");
                icon.classList.add("bi-eye-slash");
            }
        }
    </script>
@endonce
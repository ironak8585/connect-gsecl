@props([
'label',
'name' => null,
'value' => null,
'error' => null,
'required' => false,
])

<div {{ $attributes->merge(['class' => 'my-2']) }}>
    <label for="{{ $name }}"
        class="form-label font-sans antialiased text-md text-stone-800 dark:text-white font-semibold">
        {{ $label }}
        @if($required)
        <span class="text-red-500">*</span>
        @endif
    </label>
    <div class="relative w-full">
        <input type="time" name="{{ $name }}" id="{{ $name }}" value="{{ old($name, $value) }}" {{ $required
            ? 'required' : '' }} {{ $attributes }} class="form-control w-full aria-disabled:cursor-not-allowed
        outline-none focus:outline-none
        text-stone-800 dark:text-white
        placeholder:text-stone-600/60 dark:placeholder:text-stone-400
        ring-transparent border border-stone-200 dark:border-stone-600
        transition-all ease-in disabled:opacity-50 disabled:pointer-events-none
        select-none text-sm py-2 px-2.5
        ring shadow-sm bg-white dark:bg-stone-800
        rounded-lg duration-100
        hover:border-stone-300 dark:hover:border-stone-500
        hover:ring-none focus:border-stone-400 dark:focus:border-stone-500
        focus:ring-none peer focus:ring-2 dark:focus:ring-stone-500">
    </div>

    @if ($error)
    <div class="text-danger text-end mt-1">{{ $error }}</div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
            const timeInput = document.getElementById('{{ $name }}');
            if (timeInput) {
                timeInput.addEventListener('change', function () {
                    // console.log('Time input changed:', this.value);
                });
            }
        });
</script>
@endpush
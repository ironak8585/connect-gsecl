@props(['label' => null])

<button {{ $attributes->merge(['class' => 'btn btn-primary']) }} type="submit">{{ __($label ?? 'Submit') }}</button>
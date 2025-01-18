@props(['active' => false])

<a class="{{ $active ? 'active' : '' }}" {{ $attributes }} aria-current="{{ $active ? 'page' : 'false' }}">
    {{ $slot }}
</a>

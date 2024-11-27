@props(['active' => false])

<a {{ $attributes }} aria-current="{{ $active ? 'page' : 'false' }}">
    @if ($active === true)
        <ins>{{ $slot }}</ins>
    @else
        {{ $slot }}
    @endif
</a>

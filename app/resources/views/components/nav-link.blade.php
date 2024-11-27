@props(['active' => false])

@php
    $btext = '<ins>' . $slot . '</ins>';
    $text = $active ? $btext : $slot;
@endphp

<a {{ $attributes }} aria-current="{{ $active ? 'page' : 'false' }}">{!! $text !!}</a>

@props(['name'])

<label for="{{ $name }}">{{ $slot }}</label>
<input {{ $attributes->merge(['name' => $name]) }}>
@error($name)
    <p class="danger">{{ $message }}</p>
@enderror

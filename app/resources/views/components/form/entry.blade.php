@props(['name'])

<label for="{{ $name }}">{{ $slot }}</label>
<input {{ $attributes->merge(['name' => $name]) }}>
@error('{{ $name }}')
    <p>
        <span>
            {{ $message }}
        </span>
    </p>
@enderror

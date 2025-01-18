@props(['method', 'action', 'abort', 'label-confirm', 'label-abort'])

<form method="{{ $method }}" action="{{ $action }}">
    @csrf

    {{ $slot }}

    <p>
    <nav>
        <button type="submit">{{ $labelConfirm }}</button>
        <a href="{{ $abort }}">{{ $labelAbort }}</a>
    </nav>
    </p>

</form>

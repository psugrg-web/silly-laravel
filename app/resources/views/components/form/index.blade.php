@props(['method', 'action', 'labelConfirm', 'labelAbort'])

<form method="{{ $method }}" action="{{ $action }}">
    @csrf

    {{ $slot }}

    <p>
    <nav>
        <button type="submit">{{ $labelConfirm }}</button>
        <a href="{{ $action }}">{{ $labelAbort }}</a>
    </nav>
    </p>

</form>

@props(['action', 'labelConfirm', 'labelAbort'])

<form method="POST" action="{{ $action }}">
    @csrf

    {{ $slot }}

    <p>
    <nav>
        <x-form-button>{{ $labelConfirm }}</x-form-button>
        <a href="{{ $action }}">{{ $labelAbort }}</a>
    </nav>
    </p>

</form>

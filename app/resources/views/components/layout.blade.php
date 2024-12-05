<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Example navigation and header</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="icon" type="svg" href="{{ asset('list-black.svg') }}">
    <script src="{{ asset('js/nav.js') }}" defer></script>
</head>

<body class="light-mode">
    <header>
        <img src="{{ asset('list-white.svg') }}" alt="logo">
        <button class="primary-nav-toggle"></button>
        <nav class="primary-nav" data-visible="false">
            <ul>
                <li><x-nav-link href="/" :active="request()->is('/')">Home</x-nav-link></li>
                <li><x-nav-link href="/jobs" :active="request()->is('jobs')">Jobs</x-nav-link></li>
                <li><x-nav-link href="/contact" :active="request()->is('contact')">Contact</x-nav-link></li>
            </ul>
            {{-- Uncomment that for Login buttons
            <span></span>
            <form action="#">
                <button>Register</button>
            </form>
            <a href="#">Login</a>
            --}}
        </nav>
    </header>

    <div>
        <h1>{{ $heading }}</h1>
        {{ $slot }}
    </div>
</body>

</html>

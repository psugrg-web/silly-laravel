<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Silly laravel project</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/nav.js'])

    <link rel="icon" type="svg" href="{{ Vite::asset('resources/images/list-black.svg') }}">
</head>

<body class="light-mode">
    <header>
        <img src="{{ Vite::asset('resources/images/list-white.svg') }}" alt="logo">
        <button class="primary-nav-toggle"></button>
        <nav class="primary-nav" data-visible="false">
            <ul>
                <li><x-nav-link href="/" :active="request()->is('/')">Home</x-nav-link></li>
                <li><x-nav-link href="/jobs" :active="request()->is('jobs')">Jobs</x-nav-link></li>
                <li><x-nav-link href="/contact" :active="request()->is('contact')">Contact</x-nav-link></li>
            </ul>
            <span></span>
            @guest
                <x-nav-link href="/login" :active="request()->is('login')">Login</x-nav-link>
                <x-nav-link href="/register" :active="request()->is('register')">Register</x-nav-link>
            @endguest
            @auth
                <form method="POST" action="/logout">
                    @csrf

                    <button>Log Out</button>
                </form>
            @endauth
        </nav>
    </header>

    <div>
        <h1>{{ $heading }}</h1>
        <p>{{ $description ?? '' }}</p>
        <hr>
    </div>
    {{ $slot }}
</body>

</html>

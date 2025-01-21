<x-layout>
    <x-slot:heading>
        Log In
    </x-slot:heading>

    <div>
        <x-form method="POST" action='/login' abort='/' label-abort='Cancel' label-confirm='Log In'>
            <x-form.entry name="email" type="email" :value="old('email')" required>Email</x-form.entry>
            <x-form.entry name="password" type="password" required>Password</x-form.entry>
        </x-form>
    </div>

    </x-loyout>

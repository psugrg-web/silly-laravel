<x-layout>
    <x-slot:heading>
        Create User
    </x-slot:heading>

    <div>
        <x-form method="POST" action='/register' abort='/' label-abort='Cancel' label-confirm='Register'>
            <x-form.entry name="first_name" type="text" required>First Name</x-form.entry>
            <x-form.entry name="last_name" type="text" required>Last Name</x-form.entry>
            <x-form.entry name="email" type="email" required>Email</x-form.entry>
            <x-form.entry name="password" type="password" required>Password</x-form.entry>
            <x-form.entry name="password_confirmation" type="password" required>Confirm Password</x-form.entry>
        </x-form>
    </div>

    </x-loyout>

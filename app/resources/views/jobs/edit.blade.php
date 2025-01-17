<x-layout>
    <x-slot:heading>
        Edit Job: {{ $job->title }}
    </x-slot:heading>

    <div>
        <x-form method="POST" action='/jobs/{{ $job->id }}' labelAbort='Cancel' labelConfirm='Update'>
            @method('PATCH')
            <x-form.entry name="title" type="text" value="{{ $job->title }}" required>Title</x-form.entry>
            <x-form.entry name="salary" type="text" value="{{ $job->salary }}" required>Salary</x-form.entry>
        </x-form>
    </div>

    <div class="danger">
        <i class="danger">Danger zone</i>
        <nav><button class="danger" form="delete-form">Delete Job</button></nav>
        <p></p>
    </div>

    <form method="POST" action="/jobs/{{ $job->id }}" id="delete-form" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    </x-loyout>

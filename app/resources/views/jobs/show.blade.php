<x-layout>
    <x-slot:heading>
        Job
    </x-slot:heading>
    <div>
        <h2>{{ $job->title }}</h2>
        <p>
            This job pays {{ $job->salary }} per year.
        </p>
    </div>

    <div>
        <x-button href="/jobs/{{ $job->id }}/edit">Edit Job</x-button>
    </div>
    </x-loyout>

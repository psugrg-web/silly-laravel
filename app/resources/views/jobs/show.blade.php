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

    @can('edit', $job)
        <div>
            <x-button href="/jobs/{{ $job->id }}/edit">Edit Job</x-button>
        </div>
    @endcan
    </x-loyout>

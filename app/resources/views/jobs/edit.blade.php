<x-layout>
    <x-slot:heading>
        Edit Job: {{ $job->title }}
    </x-slot:heading>

    <div>
        <form method="POST" action="/jobs/{{ $job->id }}">
            @csrf
            @method('PATCH')

            <!-- NOTE: the name is important here since it's used to automatically generate a POST request -->
            <label for="title">Title</label>
            <input id="title" name="title" type="text" placeholder="Shift leader" value="{{ $job->title }}"
                required>
            @error('title')
                <p class="danger">
                    {{ $message }}
                </p>
            @enderror

            <label for="salary">Salary</label>
            <input id="salary" name="salary" type="text" placeholder="$50,000 Per Year"
                value="{{ $job->salary }}" required>
            @error('salary')
                <p class="danger">
                    {{ $message }}
                </p>
            @enderror

            <p>
            <nav>
                <button type="submit">Update</button>
                <a href="/jobs/{{ $job->id }}">Cancel</a>
            </nav>
            </p>

        </form>
    </div>

    <div>
        <hr>
        <i class="danger">Danger</i>
        <nav><button class="danger" form="delete-form">Delete Job</button></nav>
    </div>

    <form method="POST" action="/jobs/{{ $job->id }}" id="delete-form" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    </x-loyout>

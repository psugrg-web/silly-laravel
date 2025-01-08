<x-layout>
    <x-slot:heading>
        Create Job
    </x-slot:heading>

    <x-slot:description>
        We just need a handful of details from you.
    </x-slot:description>

    <div>
        <form method="POST" action="/jobs">
            @csrf

            <!-- NOTE: the name is important here since it's used to automatically generate a POST request -->
            <label for="title">Title</label>
            <input id="title" name="title" type="text" placeholder="Shift leader" value="" required>
            @error('title')
                <p>
                    <span>
                        {{ $message }}
                    </span>
                </p>
            @enderror

            <label for="salary">Salary</label>
            <input id="salary" name="salary" type="text" placeholder="$50,000 Per Year" value="" required>
            @error('salary')
                <p>
                    <span>
                        {{ $message }}
                    </span>
                </p>
            @enderror

            {{-- @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <span>{{ $error }}</span>
                @endforeach
            @endif --}}

            <p>
            <nav>
                <button type="submit">Save</button>
                <a href="#">Cancel</a>
            </nav>
            </p>

        </form>
    </div>

    </x-loyout>

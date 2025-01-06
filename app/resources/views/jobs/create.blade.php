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
            <input id="title" name="title" type="text" required="" placeholder="Shift leader" value="">

            <label for="salary">Salary</label>
            <input id="salary" name="salary" type="text" required="" placeholder="$50,000 Per Year"
                value="">

            <nav>
                <button type="submit">Save</button>
                <a href="#">Cancel</a>
            </nav>
        </form>
    </div>

    </x-loyout>

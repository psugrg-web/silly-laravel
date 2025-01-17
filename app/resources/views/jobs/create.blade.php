<x-layout>
    <x-slot:heading>
        Create Job
    </x-slot:heading>

    <x-slot:description>
        We just need a handful of details from you.
    </x-slot:description>

    <div>
        <x-form method="POST" action='/jobs' labelAbort='Cancel' labelConfirm='Save'>
            <x-form.entry name="title" type="text" placeholder="Software developer" required>Title</x-form.entry>
            <x-form.entry name="salary" type="text" placeholder="$50,000 Per Year" required>Salary</x-form.entry>
        </x-form>
    </div>

    </x-loyout>

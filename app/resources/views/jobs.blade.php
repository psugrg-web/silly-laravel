<x-layout>
    <x-slot:heading>
        Job listing
    </x-slot:heading>
    <table>
        <tbody>
            @foreach ($jobs as $job)
                <tr>
                    <td>
                        <h4>{{ $job->employer->name }}</h4>
                        <a href="/jobs/{{ $job['id'] }}">
                            <strong>{{ $job['title'] }}</strong>
                        </a>
                    </td>
                    <td>
                        Pays {{ $job['salary'] }} per year.
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </x-loyout>

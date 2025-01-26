<x-layout>
    <x-slot:heading>
        Job listing
    </x-slot:heading>
    @auth
        <div>
            <x-button href="/jobs/create">Add New Job Offer</x-button>
        </div>
    @endauth
    <div>
        <table>
            <tbody>
                <tr>
                    <th></th>
                    <th></th>
                </tr>
                @foreach ($jobs as $job)
                    <tr>
                        <td>
                            <div>
                                <h4>{{ $job->employer->name }}</h4>
                                <a href="/jobs/{{ $job['id'] }}">
                                    <strong>{{ $job['title'] }}</strong>
                                </a>
                            </div>
                        </td>
                        <td>
                            <div>
                                Pays {{ $job['salary'] }} per year.
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div>
        {{-- Pagination --}}
        {{ $jobs->links() }}
    </div>
    </x-loyout>

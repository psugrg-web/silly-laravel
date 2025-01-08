<?php

use Illuminate\Support\Facades\Route;
use App\Models\Job;

Route::get('/', function () {
    return view('home');
});

Route::get('/jobs', function () {
    // Prevent the N+1 problem by getting all the jobs in one query and also instructing Laravel to gen all employers that will also be needed
    $jobs = Job::with('employer')->latest()->paginate(3);
    return view('jobs.index', [
        'jobs' => $jobs,
    ]);
});

Route::get('/jobs/create', function () {
    return view('jobs.create');
});

// Wildcard {id} must always be declared last otherwise it will cover the more specific requests (like this one above)
Route::get('/jobs/{id}', function ($id) {

    $job = Job::find($id);

    return view('jobs.show', ['job' => $job]);
});

Route::post('/jobs', function () {
    request()->validate([
        'title' => ['required', 'min:3'],
        'salary' => ['required']
    ]);

    Job::create([
        'title' => request('title'),
        'salary' => request('salary'),
        'employer_id' => 1, // Hardcoded for now
    ]);

    return redirect('/jobs');
});

Route::get('/contact', function () {
    return view('contact');
});

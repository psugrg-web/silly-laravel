<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;


Route::view('/', 'home');
Route::view('/contact', 'contact');

Route::resource('jobs', JobController::class);

// Auth --- remember that we're following the convention...
Route::get('/register', [RegisteredUserController::class, 'create']); //  Handles the access to the registration form
Route::post('/register', [RegisteredUserController::class, 'store']); // Handles the request from the registration form

Route::get('/login', [SessionController::class, 'create']);
Route::post('/login', [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy']);

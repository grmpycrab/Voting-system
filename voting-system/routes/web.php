<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ElectionController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::post('/logout', function () {
    // Placeholder action for logout
    // You can redirect to the home page or any view you like
    return redirect('/')->with('message', 'Logged out successfully.');
})->name('logout');

// Students Management Routes
Route::resource('students', StudentController::class);
Route::resource('elections', ElectionController::class);


// Positions Management Routes
Route::get('/positions', function () {
    return view('positions.index'); // Create a positions/index.blade.php
})->name('positions.index');

// Candidates Management Routes
Route::get('/candidates', function () {
    return view('candidates.index'); // Create a candidates/index.blade.php
})->name('candidates.index');

// Results Management Routes
Route::get('/results', function () {
    return view('results.index'); // Create a results/index.blade.php
})->name('results.index');


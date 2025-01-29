<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/event', function () {
    return view('event.index');
});

Route::get('/', [EventController::class, 'index'])->name('home');
Route::resource('events', EventController::class);
Route::post('events/{event}/register', [ParticipantController::class, 'register'])->name('events.register');
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

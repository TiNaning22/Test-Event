<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/register', [AuthController::class, 'showRegister'])->name('show-register');;

Route::get('/login', [AuthController::class, 'showLogin'])->name('show-login');;
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', [EventController::class, 'index'])->name('home');
Route::resource('events', EventController::class);
Route::post('events/{event}/register', [ParticipantController::class, 'register'])->name('events.register');
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

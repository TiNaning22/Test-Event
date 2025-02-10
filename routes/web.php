<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PaymentController;

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
Route::post('events/{event}/register', [PesertaController::class, 'store'])->name('events.register');
Route::resource('dashboard', App\Http\Controllers\DashboardController::class);
Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');

Route::get('/payment', [PaymentController::class, 'index'])->name('payment.index');
Route::post('payments/token/{participant}', [PaymentController::class, 'generateToken']);
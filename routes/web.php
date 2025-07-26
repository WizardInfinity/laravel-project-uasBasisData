<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TicketController;

Route::get('/welcome', function () {
    return view('welcome');
});

// Home Route
Route::get('/', [MainController::class, 'index'])->name('home');

// Movie Route
Route::get('/movie', [MainController::class, 'movie'])->name('movie');
Route::get('/movie-detail/{id}', [MainController::class, 'movie_detail'])->name('movie_detail');

// Admin Routes
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/admin/movie/create', [AdminController::class, 'create'])->name('admin.movie.create');
    Route::post('/admin/movie', [AdminController::class, 'store'])->name('admin.movie.store');
    Route::get('/admin/movie/edit/{id}', [AdminController::class, 'edit'])->name('admin.movie.edit');
    Route::put('/admin/movie/{id}', [AdminController::class, 'update'])->name('admin.movie.update');
    Route::delete('/admin/movie/{id}',[AdminController::class, 'destroy'])->name('admin.movie.destroy');
    Route::get('/admin/data-user', [AdminController::class, 'dataUser'])->name('admin.data.user');
    Route::delete('/admin/data-user/{id}', [AdminController::class, 'deleteTicket'])->name('admin.data.user.delete');
});

//Buy Ticket Route
Route::get('/purchase', [TicketController::class, 'confirmation'])->name('buy_ticket')->middleware('auth');
Route::post('/purchase', [TicketController::class, 'store'])->name('buy_ticket.store')->middleware('auth');
Route::get('/purchase/history', [TicketController::class, 'history'])->name('purchase.history')->middleware('auth');
Route::get('/purchase/history/detail/{id}', [TicketController::class, 'detail'])->name('history.detail');
Route::get('/buy-ticket/booked-seats', [TicketController::class, 'getBookedSeats'])->name('buy_ticket.booked_seats')->middleware('auth');


// Login Route
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Register Route
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

//Logout Route
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
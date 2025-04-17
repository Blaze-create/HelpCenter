<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\DashController;
use App\Http\Controllers\UserController;

Route::get('/', [MainController::class, 'index'])->name('index');

// FALLBACK
Route::get('/login', function () {
    return redirect()->route('index')->with('status', 'Error!!')->with('message', 'Please login first');
})->name('login');



Route::middleware('auth')->group(function () {
    Route::get('/home', [MainController::class, 'home'])->name('home');


    // DASHBOARD TICKET
    Route::get('/dashboard/{filter?}', [DashController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/updateTicket/{id}', [DashController::class, 'updateTicket'])->name('updateTicket');

    // DASHBOARD USER 
    Route::get('/user-management', [UserController::class, 'index'])->name('user');
    Route::get('/get-user/{filter}', [UserController::class, 'getUser'])->name('getUser');
    Route::post('/add-user', [UserController::class, 'addUser'])->name('Add_User');
    Route::get('/dashboard/get-user-data/{id}', [UserController::class, 'getUserData'])->name('getUserData');
    Route::post('/dashboard/updateUser/{id}', [UserController::class, 'updateUser'])->name('updateUser');
});


// BASIC POST ROUTE
Route::post('/user-login', [MainController::class, 'login'])->name('user.login');
Route::post('/submit_ticket', [MainController::class, 'submit_ticket'])->name('submit_ticket');
Route::post('/logout', [MainController::class, 'destroy'])->name('logout');

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

Route::get('/', [MainController::class, 'index'])->name('index');
Route::get('/login', function () {
    return redirect()->route('index')->with('status', 'Error!!')->with('message', 'Please login first');
})->name('login');



Route::middleware('auth')->group(function () {
    Route::get('/home', [MainController::class, 'home'])->name('home');
    Route::get('/dashboard', [MainController::class, 'dashboard'])->name('dashboard');
});



Route::post('/user-login', [MainController::class, 'login'])->name('user.login');
Route::post('/submit_ticket', [MainController::class, 'submit_ticket'])->name('submit_ticket');
Route::post('/logout',[MainController::class,'destroy'])->name('logout');
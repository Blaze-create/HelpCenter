<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

Route::get('/', [MainController::class, 'index'])->name('index');
Route::get('/home', [MainController::class, 'home'])->name('home');
Route::get('/dashboard', [MainController::class, 'dashboard'])->name('dashboard');


Route::post('/login', [MainController::class, 'login'])->name('login');

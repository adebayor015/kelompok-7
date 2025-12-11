<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;   // ← WAJIB ADA
use App\Http\Controllers\ProfileController; 

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/profile', function () {
    return view('profile');
})->name('profile');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login-proses', [AuthController::class, 'prosesLogin'])->name('login.proses');

Route::get('/beranda', function () {
    return view('beranda');
})->name('beranda');

Route::get('/questions/create', [QuestionController::class, 'create'])->name('questions.create');
    return view('questions.create');



Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerProses'])->name('register.proses');

// Route edit profile
Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});
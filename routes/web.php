<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController; 
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\TopikController;

// HOME: ambil pertanyaan
Route::get('/', [QuestionController::class, 'index'])->name('home');

// PROFIL
Route::get('/profile', [ProfileController::class, 'show'])->middleware('auth')->name('profile');
Route::get('/users/{user}', [ProfileController::class, 'show'])->name('users.show');

Route::middleware('auth')->group(function () {
    Route::post('/users/{user}/follow', [ProfileController::class, 'follow'])->name('users.follow');
    Route::post('/users/{user}/unfollow', [ProfileController::class, 'unfollow'])->name('users.unfollow');
});

// LOGIN
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login-proses', [AuthController::class, 'prosesLogin'])->name('login.proses');

// BERANDA (opsional)
Route::get('/beranda', function () {
    return view('beranda');
})->name('beranda');

// CREATE QUESTION
Route::get('/questions/create', [QuestionController::class, 'create'])->name('questions.create');

// STORE QUESTION
Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store');

// SHOW QUESTION
Route::get('/questions/{id}', [QuestionController::class, 'show'])->name('questions.show');

// REGISTER
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerProses'])->name('register.proses');

// EDIT PROFILE
Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

//topik
Route::get('/topik', [TopikController::class, 'index'])->name('topik');



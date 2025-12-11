<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;   // ← WAJIB ADA
<<<<<<< HEAD
use App\Http\Controllers\ProfileController; 
=======
use App\Http\Controllers\QuestionController;

>>>>>>> bae397bdc8574b675442455acb1022fb187e7a65

Route::get('/', function () {
    return view('index');
});

Route::get('/profile', function () {
    return view('profile');
})->name('profile');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login-proses', [AuthController::class, 'prosesLogin'])->name('login.proses');

Route::get('/beranda', function () {
    return view('beranda');
})->name('beranda');

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerProses'])->name('register.proses');

<<<<<<< HEAD
// Route edit profile
Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});
=======
Route::get('/', [QuestionController::class, 'index'])->name('home');
Route::get('questions/{id}', [QuestionController::class, 'show'])->name('questions.show');
// Route untuk menampilkan form pembuatan pertanyaan baru
Route::get('/questions/create', [QuestionController::class, 'create'])->name('questions.create');
Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store');


>>>>>>> bae397bdc8574b675442455acb1022fb187e7a65

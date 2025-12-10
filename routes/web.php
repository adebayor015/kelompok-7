<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;   // ← WAJIB ADA

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

<<<<<<< Updated upstream
<<<<<<< Updated upstream

use App\Http\Controllers\PertanyaanController;
Route::get('/', [PertanyaanController::class, 'index']);




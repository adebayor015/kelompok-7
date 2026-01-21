<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController; // <-- Pastikan ini ada
use App\Http\Controllers\TopikController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| HOME (Public)
|--------------------------------------------------------------------------
*/
Route::get('/', [QuestionController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| GUEST ONLY (Belum Login)
|--------------------------------------------------------------------------
*/
Route::middleware('guestonly')->group(function () {
    // LOGIN
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login-proses', [AuthController::class, 'prosesLogin'])->name('login.proses');

    // REGISTER
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'registerProses'])->name('register.proses');
});

/*
|--------------------------------------------------------------------------
| LOGIN REQUIRED (Harus Login)
|--------------------------------------------------------------------------
*/
Route::middleware('checklogin')->group(function () {

    // LOGOUT
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/avatar/delete', [ProfileController::class, 'removeAvatar'])->name('profile.avatar.delete');
    Route::post('/profile/avatar/select', [ProfileController::class, 'selectAvatar'])->name('profile.avatar.select');
    Route::get('/profile/notifications', [ProfileController::class, 'notifications'])->name('profile.notifications');
    Route::post('/profile/notifications/mark-read', [ProfileController::class, 'markNotificationsRead'])->name('profile.notifications.mark_read');

    // FOLLOW
    Route::post('/users/{user}/follow', [ProfileController::class, 'follow'])->name('users.follow');
    Route::post('/users/{user}/unfollow', [ProfileController::class, 'unfollow'])->name('users.unfollow');

    // QUESTIONS (CRUD Lengkap)
    Route::get('/questions/create', [QuestionController::class, 'create'])->name('questions.create');
    Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store');
    Route::get('/questions/{id}/edit', [QuestionController::class, 'edit'])->name('questions.edit'); 
    Route::put('/questions/{id}', [QuestionController::class, 'update'])->name('questions.update'); 
    Route::delete('/questions/{id}', [QuestionController::class, 'destroy'])->name('questions.destroy'); 

    // ANSWERS (Fitur Balas Pertanyaan)
    Route::post('/questions/{id}/answers', [AnswerController::class, 'store'])->name('answers.store');
});

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (Bisa Diakses Siapa Saja)
|--------------------------------------------------------------------------
*/
Route::get('/questions/{id}', [QuestionController::class, 'show'])->name('questions.show');
Route::get('/users/{user}', [ProfileController::class, 'show'])->name('users.show');
Route::get('/topik', [TopikController::class, 'index'])->name('topik');
Route::get('/topik/{slug}', [TopikController::class, 'show'])->name('topik.show');
Route::get('/topik/{topic_slug}/materi/{material_slug}', [App\Http\Controllers\TopikController::class, 'showMaterial'])->name('materi.show');

// Followers / Following lists
Route::get('/users/{user}/followers', [ProfileController::class, 'followers'])->name('users.followers');
Route::get('/users/{user}/following', [ProfileController::class, 'following'])->name('users.following');
// Users listing / search
Route::get('/users', [ProfileController::class, 'index'])->name('users.index');
// AJAX user search for navbar live preview
Route::get('/users/search', [ProfileController::class, 'searchAjax'])->name('users.search');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (Login Required + Admin Only)
|--------------------------------------------------------------------------
*/
Route::middleware(['checklogin', 'adminonly'])->group(function () {
    // Dashboard
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    
    // Users Management
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.delete-user');
    
    // Questions Management
    Route::get('/admin/questions', [AdminController::class, 'questions'])->name('admin.questions');
    Route::delete('/admin/questions/{id}', [AdminController::class, 'deleteQuestion'])->name('admin.delete-question');
    
    // Topics Management
    Route::get('/admin/topics', [AdminController::class, 'topics'])->name('admin.topics');
    Route::get('/admin/topics/create', [AdminController::class, 'createTopic'])->name('admin.create-topic');
    Route::post('/admin/topics', [AdminController::class, 'storeTopic'])->name('admin.store-topic');
    Route::delete('/admin/topics/{id}', [AdminController::class, 'deleteTopic'])->name('admin.delete-topic');
    
    // Settings
    Route::get('/admin/settings', [AdminController::class, 'settings'])->name('admin.settings');
});
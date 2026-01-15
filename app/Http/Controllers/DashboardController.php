<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index'])
    ->name('home')
    ->middleware('checkLogin');


class DashboardController extends Controller
{
    public function index()
    {
        return view('index', [
            'user_name' => session('user_name'),
            'user_email' => session('user_email'),
        ]);
    }
}

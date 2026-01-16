<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('index', [
            'user_name'  => session('user_name'),
            'user_email' => session('user_email'),
        ]);
    }
}

<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user()->load('profile');

        return view('dashboard', compact('user'));
    }
}
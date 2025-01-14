<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/')->with('error', 'Unauthorized access');
        }
        
        return view('admin.dashboard');
    }
} 
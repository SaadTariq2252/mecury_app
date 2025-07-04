<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $currentPath = session('current_scoped_path');
        $scopedPath = $request->attributes->get('scoped_path');
        
        return view('dashboard', compact('user', 'currentPath', 'scopedPath'));
    }
}
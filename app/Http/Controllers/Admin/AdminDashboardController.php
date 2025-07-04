<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ScopedPath;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_paths' => ScopedPath::count(),
            'active_paths' => ScopedPath::where('is_active', true)->count(),
            'total_users' => User::count(),
            'assigned_users' => User::whereNotNull('scoped_path_id')->count(),
        ];

        $recentPaths = ScopedPath::with('users')->latest()->take(5)->get();
        $recentUsers = User::with('scopedPath')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentPaths', 'recentUsers'));
    }
}
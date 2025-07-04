<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\ScopedPath;

class ScopedAuthController extends Controller
{
    public function showLogin(string $path)
    {
        $scopedPath = ScopedPath::findByPath($path);
        
        if (!$scopedPath) {
            abort(404);
        }

        return view('auth.scoped-login', compact('path', 'scopedPath'));
    }

    public function login(Request $request, string $path)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $scopedPath = ScopedPath::findByPath($path);
        if (!$scopedPath) {
            abort(404);
        }

        // Find user with matching email and path assignment
        $user = User::where('email', $request->email)
                   ->where('scoped_path_id', $scopedPath->id)
                   ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'Invalid credentials or you do not have access to this path.',
            ])->onlyInput('email');
        }

        // Additional security: verify path access
        if (!$user->hasPathAccess($path)) {
            return back()->withErrors([
                'email' => 'You do not have access to this path.',
            ])->onlyInput('email');
        }

        Auth::login($user, $request->boolean('remember'));

        // Store authenticated path in session to prevent cross-path access
        session(['authenticated_path' => $path]);
        
        $request->session()->regenerate();

        return redirect()->intended(route('scoped.dashboard', ['path' => $path]));
    }

    public function logout(Request $request, string $path)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('scoped.login', ['path' => $path]);
    }
}
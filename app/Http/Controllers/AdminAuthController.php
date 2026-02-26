<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            $user = Auth::user();
            if (!$user->isAdmin()) {
                Auth::logout();
                return back()->withErrors(['email' => 'Немає доступу адміністратора']);
            }

            session(['admin_area_authenticated' => true]);

            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Неправильні облікові дані']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->forget('admin_area_authenticated');
        return redirect()->route('admin.login');
    }
}

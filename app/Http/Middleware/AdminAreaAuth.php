<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAreaAuth
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->is('admin/login') || $request->is('admin/login/*')) {
            return $next($request);
        }

        if (session('admin_area_authenticated') && Auth::check() && Auth::user()->isAdmin()) {
            return $next($request);
        }

        return redirect()->route('admin.login');
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // 1. Tambahkan import Facade Auth di atas

class RoleMiddleware
{
    // 2. Tambahkan tipe data string pada parameter ...$roles
    public function handle(Request $request, Closure $next, string ...$roles): Response 
    {
        // 3. Ubah auth()->check() menjadi Auth::check()
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 4. Ubah auth()->user() menjadi Auth::user()
        if (!in_array(Auth::user()->role, $roles)) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return $next($request);
    }
}
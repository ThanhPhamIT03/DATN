<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$roles): Response
    {
        // Nếu chưa đăng nhập → đưa về trang login
        if (!Auth::check()) {
            return back()->with('error', 'Bạn cần đăng nhập để truy cập.');
        }

        // Nếu đăng nhập nhưng không có quyền
        if (!in_array(Auth::user()->role, $roles)) {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập trang này.');
        }

        return $next($request);
    }
}

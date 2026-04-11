<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CanEdit
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        if (!auth()->user()->canEdit()) {
            abort(403, 'Akses ditolak. Anda hanya memiliki akses view-only.');
        }
        return $next($request);
    }
}

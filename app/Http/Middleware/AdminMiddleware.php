<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $isLogggedIn = Auth::check();
        if (!$isLogggedIn || $request->user()->role !== 'admin') {
            flash()->error('No tienes permisos para acceder a esta sección');
            return redirect()->route('funkos.index');
        }
        return $next($request);
    }
}

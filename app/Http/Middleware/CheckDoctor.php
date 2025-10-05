<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckDoctor
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->isDoctor()) {
            return $next($request);
        }
        
        return redirect('/dashboard')->with('error', 'Access denied.');
    }
}
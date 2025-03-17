<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckEmployee
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->has('employee_id')) {
            return redirect()->route('login')->withErrors(['message' => 'Please log in first.']);
        }

        return $next($request);
    }
}

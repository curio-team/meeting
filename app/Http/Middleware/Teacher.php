<?php
namespace App\Http\Middleware;
use Closure;

class Teacher
{
    public function handle($request, Closure $next)
    {
        if ( $request->user()->type != 'teacher' )
        {
            return response('Geen toegang voor studenten!', 403)
                  ->header('Content-Type', 'text/plain');
        }
        return $next($request);
    }
}
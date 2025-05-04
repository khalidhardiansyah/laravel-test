<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RecordLogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Log::channel("single")->info("REQUEST LOG",[
            "method" => $request->method(),
            "url" => $request->fullUrl(),
            "body" => $request->except(['password'])
        ]);
        return $next($request);
    }
}

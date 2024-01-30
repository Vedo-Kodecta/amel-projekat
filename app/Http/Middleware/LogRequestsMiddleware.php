<?php
namespace App\Http\Middleware;

use Closure;
use App\Logging\GlobalLogger;

class LogRequestsMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
        GlobalLogger::logRequest($request);

        return $next($request);
    }
}


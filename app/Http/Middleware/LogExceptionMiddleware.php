<?php

namespace App\Http\Middleware;

use Closure;
use App\Logging\GlobalLogger;

class LogExceptionMiddleware
{
    /**
     * Handle an incoming exception.
     */
    public function handle($request, Closure $next)
    {
         try {
            return $next($request);
        } catch (\Exception $exception) {
            GlobalLogger::logException($exception);
        }
    }
}

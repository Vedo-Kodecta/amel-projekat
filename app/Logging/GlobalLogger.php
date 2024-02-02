<?php

namespace App\Logging;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class GlobalLogger
{
    /**
     * Log every request, including the query string.
     */
    public static function logRequest($request)
    {
        
        $requestBody = $request->getContent();
        Log::channel('requests')->info("Request: " . Request::method() . " " . Request::fullUrl() . " Request Body: " . $requestBody);
    }

    /**
     * Log exceptions with stack traces.
     *
     * @param \Exception $exception
     */
    public static function logException(\Exception $exception)
    {
        Log::channel('exceptions')->warning('Exception occurred', ['exception' => $exception]);
    }

    /*
    * Add channel on which you want to log and message
    */
    public static function log($channel, $message, $context = [])
    {
        $user = auth()->user();
        if ($user) {
            $userId = $user->id;
        } else {
            $userId = 'No logged-in user';
        }

        Log::channel($channel)->info($message, array_merge(['user' => $userId], $context));
    }
}

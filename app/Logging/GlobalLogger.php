<?php

namespace App\Logging;

use Illuminate\Support\Facades\Log;

class GlobalLogger
{
    /*
    * Add channel on which u want to log and message
    */
    public static function log($channel, $message)
    {
        $user = auth()->user();
        if ($user) {
            $userId = $user->id;
        } else {
            $userId = 'No logged-in user';
        }

        Log::channel($channel)->info($message, ['user' => $userId]);
    }
}

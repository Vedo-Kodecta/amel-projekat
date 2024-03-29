<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class CustomExceptionHandler extends ExceptionHandler
{
    public function render($request, Exception|\Throwable $exception)
    {
        if ($exception instanceof QueryException) {
            return response()->json(['message' => 'Database error: ' . $exception->getMessage()], 502);
        } else {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}

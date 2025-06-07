<?php

// This is the controller for the error page, 404 and 403 and authorization errors

namespace App\controllers;

use Exception;

class ErrorController

    /**
     *404 didn't find error handler
     * @return void
     */
{
    public static function notFound($message = 'Resource not found!'): void
    {
        http_response_code(404);

        loadView('error', [
          'status' => '404',
          'message' => $message
        ]);
    }

    /**
     *403 unauthorized error handler
     * @param string $message
     * @return void
     */

    public static function unauthorized(string $message = 'You are not authorized to see this resource!'): void
    {
        http_response_code(403);

        loadView('error', [
          'status' => '403',
          'message' => $message
        ]);
    }


}
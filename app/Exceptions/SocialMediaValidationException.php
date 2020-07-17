<?php

namespace App\Exceptions;

use Exception;

class SocialMediaValidationException extends Exception
{
    protected $code = 400;

    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
        \Log::debug('social media validation failed');
    }

    public function render() {
        return response()->json([
            "status" => 'error',
            "status_code" => $this->code,
            "message" => "social media validation failed"
        ], $this->code);
    }
}

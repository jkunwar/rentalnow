<?php

namespace App\Exceptions;

use Exception;

class AppKeyException extends Exception
{
    protected $code = 401;

	public function render() {
		return response()->json([
			"status" => 'error',
			"status_code" => $this->code,
            "message" => "invalid app key"
        ], $this->code);
	}
}

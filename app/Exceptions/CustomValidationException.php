<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Contracts\Validation\Validator;

class CustomValidationException extends Exception
{
    protected $validator;
	protected $code = 422;

	public function __construct(Validator $validator) {
		$this->validator = $validator;
	}

	public function render() {
		return response()->json([
			"status" => 'error',
			"status_code" => $this->code,
            "message" => "Fields Validation Failed.",
            "data" => $this->validator->errors()
        ], $this->code);
	}
}

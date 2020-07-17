<?php

namespace App\Exceptions;

use Exception;

class GeoLocationException extends Exception
{
    protected $code = 400;

    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
        \Log::debug('can not find location');
    }


	public function render() {
		return response()->json([
			"status" => 'error',
			"status_code" => $this->code,
            "message" => "can not find location"
        ], $this->code);
	}
}

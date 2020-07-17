<?php
namespace App\Traits;

use App\Exceptions\AppKeyException;

trait AppAuthorization {

	public function authorizeToken($request) {
		$appKey = env('MOBILE_APP_KEY');
		$app_key = $request->headers->get('X-APP-TOKEN');
		if((!isset($app_key)) || ($appKey != $app_key)){
			throw new AppKeyException();
		}
		return true;
	}

}
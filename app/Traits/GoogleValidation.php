<?php

namespace App\Traits;

use App\Exceptions\SocialMediaValidationException;

trait GoogleValidation {
    public function validateGoogleToken($token, $device_type) {
        try {
            $device_type == 'android' ? $CLIENT_ID =  env('GOOGLE_CLIENT_ID_ANDROID') : $CLIENT_ID = env('GOOGLE_CLIENT_ID_IOS');
            $client = new \Google_Client(['client_id' => $CLIENT_ID]);
            $payload = $client->verifyIdToken($token);
            if (!$payload) {
                throw new SocialMediaValidationException('Social media validation failed');
            }

            return $userid = $payload['sub'];
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            throw new SocialMediaValidationException("$errorMessage");
        }
    }
}

?>
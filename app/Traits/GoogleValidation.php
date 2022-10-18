<?php

namespace App\Traits;

use App\Exceptions\SocialMediaValidationException;

trait GoogleValidation
{
    public function validateGoogleToken($token, $device_type)
    {
        try {
            $CLIENT_ID = $device_type == 'android' ? env('GOOGLE_CLIENT_ID_ANDROID') : env('GOOGLE_CLIENT_ID_IOS');
            $client = new \Google_Client(['client_id' => $CLIENT_ID]);
            $payload = $client->verifyIdToken($token);

            if (!$payload || $payload['aud'] != $CLIENT_ID || $payload['iss'] != 'https://accounts.google.com') {
                throw new SocialMediaValidationException('Social media validation failed');
            }

            return $userid = $payload['sub'];
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            throw new SocialMediaValidationException("$errorMessage");
        }
    }
}

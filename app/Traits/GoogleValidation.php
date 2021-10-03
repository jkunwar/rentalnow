<?php

namespace App\Traits;

use App\Exceptions\SocialMediaValidationException;

trait GoogleValidation {
    public function validateGoogleToken($token, $device_type) {
        try {
            $client_id = env('GOOGLE_CLIENT_ID_IOS'); //client id for iOS
            if($device_type === 'android') {
                $client_id =  env('GOOGLE_CLIENT_ID_ANDROID'); //client id for android
            }

            if(!$client_id) {
                throw new SocialMediaValidationException('GOOGLE_CLIENT_ID not set');
            }

            $client = new \Google_Client(['client_id' => $client_id]);
            $payload = $client->verifyIdToken($token);
            if ($payload) {
                return $userid = $payload['sub'];
            } else {
                throw new SocialMediaValidationException('social media validation failed');
            }
        } catch (\Exception $e) {
            throw new SocialMediaValidationException($e->getMessage());
        }
    }
}

?>
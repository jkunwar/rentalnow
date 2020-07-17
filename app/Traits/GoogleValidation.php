<?php 

namespace App\Traits;

use App\Exceptions\SocialMediaValidationException;

trait GoogleValidation {
    public function validateGoogleToken($token, $device_type) {
        try {
            $CLIENT_ID = env('GOOGLE_CLIENT_ID_IOS'); //client id for iOS
            if($device_type === 'android') {
                $CLIENT_ID =  env('GOOGLE_CLIENT_ID_ANDROID'); //client id for android
            }
            $client = new \Google_Client(['client_id' => $CLIENT_ID]);
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
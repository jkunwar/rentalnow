<?php

namespace App\Traits;

use App\Exceptions\SocialMediaValidationException;

trait FacebookValidation
{
    protected function validateFacebookToken($token)
    {
        $client_id = env('FACEBOOK_ID');
        $client_secret = env('FACEBOOK_SECRET');

        $inputToken = $token; // is the actual appuser access token
        try {
            $appTokenLink = 'https://graph.facebook.com/oauth/access_token?client_id=' . $client_id . '&client_secret=' . $client_secret . '&grant_type=client_credentials';

            $appToken = json_decode(file_get_contents($appTokenLink), true);

            $link = 'https://graph.facebook.com/debug_token?input_token=' . $inputToken . '&access_token=' . $appToken['access_token'];
            $obj = json_decode(file_get_contents($link), true);

            if ($obj['data']['is_valid'] === false) {
                throw new SocialMediaValidationException('social media validation failed');
            }
            return $obj;
        } catch (\Exception $e) {
            throw new SocialMediaValidationException('social media validation failed');
        }
    }
}

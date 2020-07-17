<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceToken extends Model
{
    protected $fillable = [
        'user_id', 'fcm_token', 'device_id', 'device_type'
    ];

    public function storeUserDevice($request, $user_id) {
    	$device = $this->ifDeviceTokenExists($request->fcm_token, $user_id);
    	if(!$device) {
	    	$device = DeviceToken::create([
	    		'user_id'	  => $user_id,
	        	'fcm_token'   => $request->fcm_token,
	        	'device_id'   => $request->device_id,
	        	'device_type' => $request->device_type
	    	]);
    	}
    	return $device;
    }

    public function ifDeviceTokenExists($fcmToken, $user_id) {
    	return DeviceToken::where([['fcm_token', $fcmToken], ['user_id', $user_id]])->first();
    }

    public function deleteByFcmToken($fcmToken) {
        DeviceToken::where([['fcm_token', $fcmToken], ['user_id', auth()->user()->id]])->delete();
    }
}

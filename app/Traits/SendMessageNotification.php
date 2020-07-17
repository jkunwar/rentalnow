<?php

	namespace App\Traits;
	use PushNotification;
	use App\Models\DeviceToken;

	trait SendMessageNotification {

		public function sendNotification($to, $from, $message, $messageId) {

			$tokens = DeviceToken::where('user_id',$to)->pluck('fcm_token')->toArray();
			
	        $msg = str_limit($message,100);

	        if(count($tokens) > 0) {
				PushNotification::setService('fcm')
					->setMessage([
						'notification'=> [
							'title' => 'You have new message',
							'body' => $msg,
							'sound' => 'default',
							'icon' => 'default'
						],
						'data' => [
							'messageId' => $messageId,
							'title' => 'You have new message',
							'message' => $msg,
							'to' => $to,
							'from' => $from
						],
					])
		    		->setDevicesToken($tokens)
		    		->send()
		    		->getFeedback();
			}
	}

}



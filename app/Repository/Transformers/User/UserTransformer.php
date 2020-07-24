<?php 

namespace App\Repository\Transformers\User;

use App\Repository\Transformers\Transformer;

class UserTransformer extends Transformer {

	public function transform($user) {
		return [
			'id'			=> $user->id,
			'name' 			=> $user->name,
			'dob' 			=> $user->dob,
			'email' 		=> $user->email,
			'gender' 		=> $user->gender,
			'phone_number' 	=> $user->phone_number,
			'profile_image' => $user->profile_image,
			'address' 		=> [
				'id' 			=> $user->address_id,
				'location' 		=> $user->location,
				'location_id' 	=> $user->location_id,
				'latitude' 		=> (float)$user->latitude,
				'longitude' 	=> (float)$user->longitude,
			],
			'created_at' => $user->created_at->format('Y-m-d h:i:s'),
			'updated_at' => $user->updated_at->format('Y-m-d h:i:s'),
		];
	}
}
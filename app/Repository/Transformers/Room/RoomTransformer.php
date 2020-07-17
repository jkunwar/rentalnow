<?php 

namespace App\Repository\Transformers\Room;

use App\Repository\Transformers\Transformer;

class RoomTransformer extends Transformer {

	public function transform($room) {
		return [
			'id'	=> $room->id,
			'title' => $room->title,
			'currency' => strtoupper($room->currency),
			'rent'	=> (float)$room->rent,
			'description' => $room->description,
			'type'	=> 'room',

			'building_type' => $room->building_type,
			'move_in_fee' => (float)$room->move_in_fee,
			'utilities_cost' => (float)$room->utilities_cost,
			'parking_rent'	=> (float)$room->parking_rent,
			'furnished' => (boolean)$room->furnished,
			'pets_allowed' => (boolean)$room->pets_allowed,
			'is_available' => (boolean)$room->is_available,
			
			'created_at' => $room->created_at->format('Y-m-d h:i:s'),
			'updated_at' => $room->updated_at->format('Y-m-d h:i:s'),
			
			'images' => $room->images,
			'favourite' => (boolean)$room->favourite,
			'user'	=> [
				'id' => $room->user_id,
				'name' => $room->username,
				'phone_number' => $room->phone_number,
				'email' => $room->email,
				'profile_image' => $room->profile_image
			],
			'address' => [
				'id' => $room->address_id,
				'location' => $room->location,
				'location_id' => $room->location_id,
				'latitude' => (float)$room->latitude,
				'longitude' => (float)$room->longitude,
			],
			'amenities' => $room->amenities
		];
	}
}
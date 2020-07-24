<?php 

namespace App\Repository\Transformers\House;

use App\Repository\Transformers\Transformer;

class HouseTransformer extends Transformer {

	public function transform($house) {
		return [
			'id'				=> $house->id,
			'title' 			=> $house->title,
			'currency' 			=> strtoupper($house->currency),
			'rent'				=> (float)$house->rent,
			'description' 		=> $house->description,
			'type'				=> 'house',
			
			'bedrooms' 			=> (float)$house->bedrooms,
			'bathrooms' 		=> (float)$house->bathrooms,
			'measurement' 		=> (float)$house->measurement,
			'measurement_unit'	=> $house->m_unit,
			'furnished' 		=> (boolean)$house->furnished,
			'pets_allowed' 		=> (boolean)$house->pets_allowed,
			'is_available' 		=> (boolean)$house->is_available,
			'created_at' 		=> $house->created_at->format('Y-m-d h:i:s'),
			'updated_at' 		=> $house->updated_at->format('Y-m-d h:i:s'),
			
			'images' 			=> $house->images,
			'favourite' 		=> (boolean)$house->favourite,
			'user'	=> [
				'id' 			=> $house->user_id,
				'name' 			=> $house->username,
				'phone_number' 	=> $house->phone_number,
				'email' 		=> $house->email,
				'profile_image' => $house->profile_image
			],
			'address' => [
				'id' 			=> $house->address_id,
				'location' 		=> $house->location,
				'location_id' 	=> $house->location_id,
				'latitude' 		=> (float)$house->latitude,
				'longitude' 	=> (float)$house->longitude,
			],
			'amenities' 		=> $house->amenities
		];
	}
}
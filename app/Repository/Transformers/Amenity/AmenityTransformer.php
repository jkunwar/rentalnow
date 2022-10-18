<?php

namespace App\Repository\Transformers\Amenity;

use App\Repository\Transformers\Transformer;

class AmenityTransformer extends Transformer
{

	public function transform($amenity)
	{
		return [
			'id'	=> $amenity->id,
			'title' => $amenity->title,
			'created_at' => $amenity->created_at->format('Y-m-d h:i:s'),
			'updated_at' => $amenity->updated_at->format('Y-m-d h:i:s'),
		];
	}
}

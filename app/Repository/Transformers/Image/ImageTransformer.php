<?php

namespace App\Repository\Transformers\Image;

use App\Repository\Transformers\Transformer;

class ImageTransformer extends Transformer
{

	public function transform($image)
	{
		return [
			'id'	=> $image->id,
			'item_id' => $image->room_id ? $image->room_id : $image->house_id,
			'image_path' => $image->image_path,

			'created_at' => $image->created_at->format('Y-m-d h:i:s'),
			'updated_at' => $image->updated_at->format('Y-m-d h:i:s'),
		];
	}
}

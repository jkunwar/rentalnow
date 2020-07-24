<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Img;

class HouseImage extends Model
{
    protected $fillable = ['house_id', 'image_path'];

    public function uploadImage($request, $houseId) {
    	if($request->hasFile('image')) {
            $file_name = date('ymdhis');
            $extname = $request->file('image')->getClientOriginalExtension();
            $file_name_to_store = $file_name.'.'.$extname;
            $path = $request->file('image')->storeAs('public/images/house',$file_name_to_store);
            
            $img = Img::make($request->file('image')->getRealPath());
            $img->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            Storage::put('public/thumbnails/house/small_'.$file_name_to_store, (string) $img->encode());
            
            $data = HouseImage::create([
	            'house_id' => $houseId,
	            'image_path' => 'storage/images/house/'.$file_name_to_store
            ]);

            return $data;
        }
    }

    public function deleteImagesByHouseId($houseId) {
        $images = HouseImage::where('house_id', $houseId)->get();
        if(count($images) > 0) {
            foreach ($images as $image) {
                $image_name = explode('/', $image->image_path);
                unlink('storage/images/house/'.$image_name[3]);
                unlink('storage/thumbnails/house/small_'.$image_name[3]);
            }
            
            HouseImage::where('house_id', $houseId)->delete();
        }
    }
}

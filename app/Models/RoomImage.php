<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Img;

class RoomImage extends Model
{
    protected $fillable = ['room_id', 'image_path'];

    public function uploadImage($request, $id) {
    	if($request->hasFile('image')) {
            $file_name = date('ymdhis');
            $extname = $request->file('image')->getClientOriginalExtension();
            $file_name_to_store = $file_name.'.'.$extname;
            $path = $request->file('image')->storeAs('public/images/room',$file_name_to_store);
            
            $img = Img::make($request->file('image')->getRealPath());
            $img->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            Storage::put('public/thumbnails/room/small_'.$file_name_to_store, (string) $img->encode());
            
            $data = RoomImage::create([
	            'room_id' => $id,
	            'image_path' => 'storage/images/room/'.$file_name_to_store
            ]);
            return $data;
        }
    }

    public function deleteImagesByRoomId($roomId) {
        $images = RoomImage::where('room_id', $roomId)->get();
        if(count($images) > 0) {
            foreach ($images as $image) {
                $image_name = explode('/', $image->image_path);
                unlink('storage/images/room/'.$image_name[3]);
                unlink('storage/thumbnails/room/small_'.$image_name[3]);
            }
            RoomImage::where('room_id', $roomId)->delete();
        }
    }
}

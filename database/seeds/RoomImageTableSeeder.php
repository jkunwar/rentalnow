<?php

use App\Models\RoomImage;
use Illuminate\Database\Seeder;

class RoomImageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1; $i <= 500; $i++) {
        	RoomImage::create([
        		'room_id' => $i,
        		'image_path' => '/storage/images/room/room1.jpg'
        	]);
        	RoomImage::create([
        		'room_id' => $i,
        		'image_path' => '/storage/images/room/room2.jpg'
        	]);
        	RoomImage::create([
        		'room_id' => $i,
        		'image_path' => '/storage/images/room/room3.jpg'
        	]);
        	RoomImage::create([
        		'room_id' => $i,
        		'image_path' => '/storage/images/room/room4.jpg'
        	]);
        }
    }
}

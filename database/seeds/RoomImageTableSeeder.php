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
        		'image_path' => 'https://source.unsplash.com/400x400/?room'
        	]);
        	RoomImage::create([
        		'room_id' => $i,
        		'image_path' => 'https://source.unsplash.com/400x400/?room'
        	]);
        	RoomImage::create([
        		'room_id' => $i,
        		'image_path' => 'https://source.unsplash.com/400x400/?room'
        	]);
        	RoomImage::create([
        		'room_id' => $i,
        		'image_path' => 'https://source.unsplash.com/400x400/?room'
        	]);
        }
    }
}

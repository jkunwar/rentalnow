<?php

use App\Models\Room;
use App\Models\Amenity;
use App\Models\AmenityRoom;
use Illuminate\Database\Seeder;

class AmenityRoomTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $amenity_rooms = factory(App\Models\AmenityRoom::class, 200)->create();
		$amenities = Amenity::where('amenity_for', 'rooms')->orWhere('amenity_for', 'both')->pluck('id')->toArray();

        $rooms = Room::get();
        foreach($rooms as $room) {
            AmenityRoom::create([
            	'amenity_id' => $amenities[array_rand($amenities, 1)],
    			'room_id' => $room->id
            ]);
        }
    }
}

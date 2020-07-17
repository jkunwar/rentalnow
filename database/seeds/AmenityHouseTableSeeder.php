<?php

use App\Models\House;
use App\Models\Amenity;
use App\Models\AmenityHouse;
use Illuminate\Database\Seeder;

class AmenityHouseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $amenity_houses = factory(App\Models\AmenityHouse::class, 200)->create();
        $amenities = Amenity::where('amenity_for', 'houses')->orWhere('amenity_for', 'both')->pluck('id')->toArray();

        $houses = House::get();
        foreach($houses as $house) {
            AmenityHouse::create([
            	'amenity_id' => $amenities[array_rand($amenities, 1)],
    			'house_id' => $house->id
            ]);
        }
    }
}

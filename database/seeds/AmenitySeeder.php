<?php

use App\Models\Amenity;
use Illuminate\Database\Seeder;

class AmenitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$amenities = [
    		['title' =>'laundry', 'amenity_for' => 'both'],
            ['title' =>'parking lot', 'amenity_for' => 'both'],
            ['title' =>'covered parking', 'amenity_for' => 'both'],
            ['title' =>'near bus stop', 'amenity_for' => 'both'],
            ['title' =>'wireless internet', 'amenity_for' => 'both'],
            ['title' =>'garage', 'amenity_for' => 'both'],
            ['title' =>'carpet', 'amenity_for' => 'both'],
            ['title' =>'near subway', 'amenity_for' => 'both'],
            ['title' =>'dishwasher', 'amenity_for' => 'both'],
            ['title' =>'private closet', 'amenity_for' => 'both'],
            ['title' =>'air conditioning', 'amenity_for' => 'both'],
        	['title' =>'elevator', 'amenity_for' => 'both'],

            ['title' =>'private entrance', 'amenity_for' => 'rooms'],

            ['title' =>'swimming pool', 'amenity_for' => 'houses'],
            ['title' =>'high-rise', 'amenity_for' => 'houses'],
            ['title' =>'low-rise', 'amenity_for' => 'houses']
    	];
    	foreach ($amenities as $amenity) {
	        Amenity::create($amenity);
    	}
    }
}

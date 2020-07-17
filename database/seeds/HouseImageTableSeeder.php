<?php

use App\Models\HouseImage;
use Illuminate\Database\Seeder;

class HouseImageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1; $i <= 500; $i++) {
        	HouseImage::create([
        		'house_id' => $i,
        		'image_path' => '/storage/images/house/house1.jpg'
        	]);
        	HouseImage::create([
        		'house_id' => $i,
        		'image_path' => '/storage/images/house/house2.jpg'
        	]);
        	HouseImage::create([
        		'house_id' => $i,
        		'image_path' => '/storage/images/house/house3.jpg'
        	]);
        	HouseImage::create([
        		'house_id' => $i,
        		'image_path' => '/storage/images/house/house4.jpg'
        	]);
        }
    }
}

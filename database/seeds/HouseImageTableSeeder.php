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
        		'image_path' => 'https://source.unsplash.com/400x400/?house'
        	]);
        	HouseImage::create([
        		'house_id' => $i,
        		'image_path' => 'https://source.unsplash.com/400x400/?house'
        	]);
        	HouseImage::create([
        		'house_id' => $i,
        		'image_path' => 'https://source.unsplash.com/400x400/?house'
        	]);
        	HouseImage::create([
        		'house_id' => $i,
        		'image_path' => 'https://source.unsplash.com/400x400/?house'
        	]);
        }
    }
}

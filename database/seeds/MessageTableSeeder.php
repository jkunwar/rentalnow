<?php

use App\Models\Message;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class MessageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$faker = Faker::create();

        for($i = 0; $i <= 5; $i++) {
        	Message::create([
        		'from' 	=> '501',
        		'to'	=> '1',
        		'message' => $faker->paragraph
        	]);

        	Message::create([
        		'from' 	=> '501',
        		'to'	=> '1',
        		'message' => $faker->paragraph
        	]);

        	Message::create([
        		'from' 	=> '501',
        		'to'	=> '2',
        		'message' => $faker->paragraph
        	]);

        	Message::create([
        		'from' 	=> '501',
        		'to'	=> '2',
        		'message' => $faker->paragraph
        	]);

        	Message::create([
        		'from' 	=> '1',
        		'to'	=> '501',
        		'message' => $faker->paragraph
        	]);

        	Message::create([
        		'from' 	=> '1',
        		'to'	=> '501',
        		'message' => $faker->paragraph
        	]);

        	Message::create([
        		'from' 	=> '2',
        		'to'	=> '501',
        		'message' => $faker->paragraph
        	]);

        	Message::create([
        		'from' 	=> '2',
        		'to'	=> '501',
        		'message' => $faker->paragraph
        	]);

        	Message::create([
        		'from' 	=> '502',
        		'to'	=> '1',
        		'message' => $faker->paragraph
        	]);

        	Message::create([
        		'from' 	=> '502',
        		'to'	=> '1',
        		'message' => $faker->paragraph
        	]);

        	Message::create([
        		'from' 	=> '502',
        		'to'	=> '2',
        		'message' => $faker->paragraph
        	]);

        	Message::create([
        		'from' 	=> '502',
        		'to'	=> '2',
        		'message' => $faker->paragraph
        	]);

        	Message::create([
        		'from' 	=> '1',
        		'to'	=> '502',
        		'message' => $faker->paragraph
        	]);

        	Message::create([
        		'from' 	=> '1',
        		'to'	=> '502',
        		'message' => $faker->paragraph
        	]);

        	Message::create([
        		'from' 	=> '2',
        		'to'	=> '502',
        		'message' => $faker->paragraph
        	]);

        	Message::create([
        		'from' 	=> '2',
        		'to'	=> '502',
        		'message' => $faker->paragraph
        	]);
        }
    }
}

<?php

use App\Models\Admin\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Admin::create([
        	'name' => 'administrator',
        	'email' => 'admin@email.com',
        	'password' => bcrypt('password'),
        ]);
    }
}

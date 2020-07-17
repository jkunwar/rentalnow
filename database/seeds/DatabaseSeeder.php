<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(AmenitySeeder::class);
        $this->call(AddressTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ProviderTableSeeder::class);
        $this->call(RoomTableSeeder::class);
        $this->call(AmenityRoomTableSeeder::class);
        $this->call(RoomImageTableSeeder::class);
        $this->call(HouseTableSeeder::class);
        $this->call(AmenityHouseTableSeeder::class);
        $this->call(HouseImageTableSeeder::class);
        $this->call(MessageTableSeeder::class);
    }
}

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware'=>['api'],'prefix'=>'/v1',  'namespace' => 'Api\V1\Auth'], function(){
    Route::post('/login', 'LoginController@login');
    Route::post('/tokens/refresh', 'LoginController@refreshToken');

	// Route::post('/login/{social}/callback','LoginController@handleProviderCallback')->where('social','twitter|facebook|linkedin|google');
});

Route::group(['middleware' => ['auth:api'], 'prefix' => '/v1', 'namespace' => 'Api\V1'], function() {
	//users
	Route::put('/users/{user_id}', 'User\UserController@update');
	Route::post('/users/{user_id}/images', 'User\UserController@updateProfileImage');

	//store device info
	Route::post('/devices/tokens', 'Device\DeviceController@store');

	//rooms
	Route::post('/rooms', 'Room\RoomController@store');
	Route::post('/rooms/{room_id}/images', 'Room\RoomController@storeImages');
	Route::put('/rooms/{room_id}/available', 'Room\RoomController@markAvailable');
	Route::put('/rooms/{room_id}/unavailable', 'Room\RoomController@markUnavailable');
	Route::put('/rooms/{room_id}', 'Room\RoomController@update');
	Route::delete('/rooms/{room_id}', 'Room\RoomController@delete');
	Route::post('/rooms/{room_id}/favourites', 'Favourite\FavouriteRoomController@makeRoomFavourite');
	Route::delete('/rooms/{room_id}/favourites', 'Favourite\FavouriteRoomController@deleteFavouriteRoom');

	//houses
	Route::post('/houses', 'House\HouseController@store');
	Route::post('/houses/{house_id}/images', 'House\HouseController@storeImages');
	Route::put('/houses/{house_id}/available', 'House\HouseController@markAvailable');
	Route::put('/houses/{house_id}/unavailable', 'House\HouseController@markUnavailable');
	Route::put('/houses/{house_id}', 'House\HouseController@update');
	Route::delete('/houses/{house_id}', 'House\HouseController@delete');
	Route::post('/houses/{house_id}/favourites', 'Favourite\FavouriteHouseController@makeHouseFavourite');
	Route::delete('/houses/{house_id}/favourites', 'Favourite\FavouriteHouseController@deleteFavouriteHouse');

	//favourites
	Route::get('/rooms/favourites', 'Favourite\FavouriteRoomController@favouriteRooms');
	Route::get('/houses/favourites', 'Favourite\FavouriteHouseController@favouriteHouses');

	//messages
	Route::get('/messages', 'Message\MessageController@getMessages');
	Route::get('/messages/{user_id}', 'Message\MessageController@getUserMessage');
	Route::post('/messages/{user_id}', 'Message\MessageController@sendMessage');

	//logout
	Route::post('/logout','Auth\LoginController@logout');
});

Route::group(['middleware'=>['api'],'prefix'=>'/v1',  'namespace' => 'Api\V1'], function(){
	Route::get('/suggestions', 'Search\SearchController@getSuggestions');
	Route::get('/search/{location_id}', 'Search\SearchController@getLatLngFromLocationId');

	//users
	Route::get('/users/{user_id}', 'User\UserController@show');
	Route::get('/users/{user_id}/rooms', 'User\UserController@getUserRooms');
	Route::get('/users/{user_id}/houses', 'User\UserController@getUserHouses');

	//amenities
	Route::get('/amenities/{amenity_for}', 'Amenity\AmenityController@getAmenities');

	//rooms
	Route::get('/rooms', 'Room\RoomController@index');
	Route::get('/rooms/{room_id}', 'Room\RoomController@show');

	//houses
	Route::get('/houses', 'House\HouseController@index');
	Route::get('/houses/{house_id}', 'House\HouseController@show');
});

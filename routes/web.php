<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', function () {
    return view('welcome');
});

// Auth::routes();


Route::prefix('admin')->group(function () {
	Route::get('/', 'Admin\AdminController@index')->name('admin.dashboard');
	Route::get('dashboard', 'Admin\AdminController@index')->name('admin.dashboard');
	Route::get('register', 'Admin\AdminController@create')->name('admin.register');
	Route::post('register', 'Admin\AdminController@store')->name('admin.register.store');
	Route::get('login', 'Admin\Auth\LoginController@showLoginForm')->name('admin.auth.login');
	Route::post('login', 'Admin\Auth\LoginController@login')->name('admin.auth.loginAdmin');
	Route::post('logout', 'Admin\Auth\LoginController@logout')->name('admin.auth.logout');

	//get users
	Route::get('users', 'Admin\User\UserController@index')->name('admin.user.index');
	Route::get('users/{user_id}', 'Admin\User\UserController@show')->name('admin.user.show');
	Route::post('users', 'Admin\User\UserController@dataTableUsers')->name('admin.datatable.users');

	Route::post('users/{user_id}/rooms', 'Admin\User\UserController@datatableUserRooms')->name('admin.datatable.users.rooms');
	Route::post('users/{user_id}/houses', 'Admin\User\UserController@datatableUserHouses')->name('admin.datatable.users.houses');

	//get rooms
	Route::get('rooms', 'Admin\Room\RoomController@index')->name('admin.room.index');
	// Route::get('rooms/{room_id}', 'Admin\Room\RoomController@show')->name('admin.room.show');
	Route::post('rooms', 'Admin\Room\RoomController@dataTablerooms')->name('admin.datatable.rooms');

	//get houses
	Route::get('houses', 'Admin\House\HouseController@index')->name('admin.house.index');
	// Route::get('houses/{house_id}', 'Admin\House\HouseController@show')->name('admin.house.show');
	Route::post('houses', 'Admin\House\HouseController@dataTablehouses')->name('admin.datatable.houses');
});

Route::get('/auth/{social}','Api\V1\Auth\LoginController@socialLogin')->where('social','twitter|facebook|linkedin|google');

// Route::get('/{path}', 'Api\V1\ReactController@index')->where('path', '([A-z\d-\/_.]+)?');


// Route::get('/home', 'HomeController@index')->name('home');
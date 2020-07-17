<?php

namespace App\Http\Controllers\Admin\User;

use DateTime;
use DataTables;
use App\Models\User;
use App\Models\Room;
use App\Models\House;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct() {
    	$this->middleware('auth:admin');
    }

    public function index() {
    	return view('admin.users.index');
    }

    public function datatableUsers(Request $request) {
        $users = (new User)->userDataTableQuery();

        return DataTables::eloquent($users)
                ->setRowId('id')
                // ->editColumn('name', '<a href="{{ route("admin.user.show", ["id" => $id]) }}" >{{$name}}</a>')
                ->editColumn('created_at', function(User $users) {
                    $date = new DateTime($users->created_at);
                    return $date->format('M j, Y h:i A') . "\n";        
                })
                ->rawColumns(['name'])
                ->make(true);
    }

    public function datatableUserRooms(Request $request, $id) {
        $rooms = (new Room)->roomDataTableQuery()->where('rooms.user_id', $id);

        return DataTables::eloquent($rooms)
                ->setRowId('id')
                // ->editColumn('name', '<a href="{{ route("admin.user.show", ["id" => $id]) }}" >{{$name}}</a>')
                ->editColumn('created_at', function(Room $rooms) {
                    $date = new DateTime($rooms->created_at);
                    return $date->format('M j, Y h:i A') . "\n";        
                })
                ->rawColumns(['name'])
                ->make(true);
    }

    public function datatableUserHouses(Request $request, $id) {
        $houses = (new House)->houseDataTableQuery()->where('houses.user_id', $id);

        return DataTables::eloquent($houses)
                ->setRowId('id')
                // ->editColumn('name', '<a href="{{ route("admin.user.show", ["id" => $id]) }}" >{{$name}}</a>')
                ->editColumn('created_at', function(House $houses) {
                    $date = new DateTime($houses->created_at);
                    return $date->format('M j, Y h:i A') . "\n";        
                })
                ->rawColumns(['name'])
                ->make(true);
    }

    public function show($id) {
    	$user = (new User)->getUserById((int)$id);
        $room_count = Room::where('user_id', (int)$id)->count();
        $house_count = House::where('user_id', (int)$id)->count();
        return view('admin.users.show', compact('user','room_count','house_count'));
    }
}

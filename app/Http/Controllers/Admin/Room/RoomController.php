<?php

namespace App\Http\Controllers\Admin\Room;

use DateTime;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class RoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        return view('admin.rooms.index');
    }

    public function datatableRooms(Request $request)
    {

        $rooms = (new Room)->roomDataTableQuery();

        return DataTables::eloquent($rooms)
            ->setRowId('id')
            // ->editColumn('name', '<a href="{{ route("admin.user.show", ["id" => $id]) }}" >{{$name}}</a>')
            ->editColumn('created_at', function (Room $rooms) {
                $date = new DateTime($rooms->created_at);
                return $date->format('M j, Y h:i A') . "\n";
            })
            ->rawColumns(['name'])
            ->make(true);
    }

    public function show($id)
    {
        return User::findOrFail($id);
    }
}

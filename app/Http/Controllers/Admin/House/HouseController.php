<?php

namespace App\Http\Controllers\Admin\House;

use DateTime;
use DataTables;
use App\Models\House;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HouseController extends Controller
{
    public function __construct() {
    	$this->middleware('auth:admin');
    }

    public function index() {
    	return view('admin.houses.index');
    }

    public function datatablehouses(Request $request) {
        
        $houses = (new House)->houseDataTableQuery();
            
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
    	return User::findOrFail($id);
    }
}

<?php

namespace App\Http\Controllers\Api\V1;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReactController extends Controller
{
    public function index() {
        $user = Auth::user();
        return view('app', compact('user'));
    }
}

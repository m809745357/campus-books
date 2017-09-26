<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BindMobileController extends Controller
{
    public function index()
    {
        return view('users.bindmobile');
    }
}

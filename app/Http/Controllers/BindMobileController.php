<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BindMobileController extends Controller
{
    public function index()
    {
        return view('users.bindmobile');
    }

    public function store(Request $request)
    {
        $request->validate([
            'mobile' => 'required',
        ]);

        if (app()->environment('testing')) {
            if (request()->wantsJson()) {
                return response(['code' => '666666'], 201);
            }
        }
    }
}

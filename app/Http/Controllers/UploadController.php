<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $this->validate(request(), [
            'file' => ['required', 'file']
        ]);

        return response(request()->file('file')->store('books', 'public'), 201);
    }
}

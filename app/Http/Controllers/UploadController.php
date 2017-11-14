<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    /**
     * [__construct description]
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 保存文件
     *
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'file' => ['required', 'file']
        ]);

        return response(request()->file('file')->store($request->directory ?? 'books', 'public'), 201);
    }
}

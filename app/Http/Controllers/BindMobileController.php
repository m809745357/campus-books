<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BindMobileController extends Controller
{
    /**
     * [__construct description]
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 绑定手机页面
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! is_null(auth()->user()->mobile)) {
            return back();
        }
        return view('users.bindmobile');
    }

    /**
     * 绑定手机页面
     *
     * @return \Illuminate\Http\Response
     */
    public function change()
    {
        $user = auth()->user();
        return view('users.changemobile', compact('user'));
    }

    /**
     * 验证手机
     *
     * @return [type] [description]
     */
    public function validatemobile()
    {
        request()->validate([
            'mobile' => 'required',
            'code' => 'required'
        ]);

        $isValidate =  auth()->user()->validateMobile();

        return response(['validate' => $isValidate], 201);
    }

    /**
     * 发送短信
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'mobile' => 'required',
        ]);

        if (app()->environment('testing')) {
            if (request()->wantsJson()) {
                return response(['code' => '666666'], 201);
            }
        }
    }
}

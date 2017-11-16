<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sms;
use App\Notifications\SmsNotification;

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

        if ($isValidate) {
            auth()->user()->markSmsAsRead();
            return response(['validate' => $isValidate], 201);
        }

        return response('验证失败', 400);
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

        # 通知发送短信
        \Notification::send(auth()->user(), new SmsNotification($request->mobile));

        return response()->json(['info' => '短信发送成功，请注意查收'], 201);
    }

    /**
     * 手机验证码发送&验证
     *
     * @param  Request $request [description]
     * @param  [type]  $mobile  [description]
     * @return [type]           [description]
     */
    public function verify(Request $request)
    {
        request()->validate([
            'mobile' => 'required',
            'code' => 'required'
        ]);

        if (auth()->user()->validateCode()) {
            auth()->user()->markSmsAsRead();
            return response()->json(['info' => '验证成功'], 201);
        }

        return response('验证失败', 400);
    }
}

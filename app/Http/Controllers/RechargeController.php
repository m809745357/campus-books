<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recharge;
use App\Models\PaymentRecord;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Payment\Order;

class RechargeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 充值界面
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recharges = Recharge::latest('money')->get();

        return view('users.recharges', compact('recharges'));
    }


    /**
     * 创建充值
     *
     * @param  Recharge $recharge
     * @return [type]             [description]
     */
    public function store(Recharge $recharge, Application $app)
    {
        if (app()->environment('testing')) {
            return $recharge->billed(array('remark' => '充值', 'change_type' => 'increment'));
        }

        $payment = $app->payment;
        $out_trade_no = $this->getOutTradeNo();

        $attributes = [
            'trade_type'       => 'JSAPI', // JSAPI，NATIVE，APP...
            'body'             => '余额充值',
            'detail'           => '余额充值：' . $recharge->money,
            'out_trade_no'     => $out_trade_no,
            'total_fee'        => $recharge->money, // 单位：分
            'notify_url'       => config('app.url') . '/wechat/notify', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            'openid'           => auth()->user()->openid, // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
            'attach'           => '余额充值'
        ];

        $order = new Order($attributes);
        $result = $payment->prepare($order);

        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){
            $prepayId = $result->prepay_id;
            $recharge->addPaymentRecord(array(
                'out_trade_no' => $out_trade_no,
                'prepay_id' => $prepayId,
                'status' => 0
            ));

            return $payment->configForJSSDKPayment($prepayId);
        }

        return response('创建订单失败', 400);
    }

    private function getOutTradeNo()
    {
        return config('wechat.payment.merchant_id') . date('YmdHis') . rand(1000, 9999);
    }
}

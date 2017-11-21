<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Thread;
use App\Models\Demand;
use App\Models\Book;
use App\Models\Carousel;
use App\Models\PaymentRecord;
use Illuminate\Http\Request;
use EasyWeChat\Foundation\Application;

class WechatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }
    /**
     * home
     * @param  Thread $thread thread
     * @return [type]           [description]
     */
    public function index(Thread $thread)
    {
        $trendingThreads = resolve('ThreadTrending')->trending(2);
        $trendingDemands = resolve('DemandTrending')->trending(3);
        $trendingPbooks = Book::where(['type' => 'PBook'])->with('onwer', 'category')->where('status' , 1)->latest('views_count')->paginate(4);
        $trendingEbooks = Book::where(['type' => 'EBook'])->with('onwer', 'category')->where('status' , 1)->latest('views_count')->paginate(4);

        $carousels = Carousel::where(['type' => 'home'])->get();

        return view('home', compact('trendingThreads', 'trendingDemands', 'trendingPbooks', 'trendingEbooks', 'carousels'));

    }

    /**
     * home
     * @param  Application $app wechat
     * @return [type]           [description]
     */
    public function notify(Application $app)
    {
        $response = $app->payment->handleNotify(function($notify, $successful){
            // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
            $paymentRecord = PaymentRecord::with('paymented')->where('out_trade_no', $notify->out_trade_no)->first();

            if (!$paymentRecord) { // 如果订单不存在
                return 'Order not exist.'; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }
            // 如果订单存在
            // 检查订单是否已经更新过支付状态
            if ($paymentRecord->paid_at) { // 假设订单字段“支付时间”不为空代表已经支付
                return true; // 已经支付成功了就不再更新了
            }
            // 用户是否支付成功
            if ($successful) {
                // 不是已经支付状态则修改为已经支付状态
                $paymentRecord->paid_at = time(); // 更新支付时间为当前时间
                $paymentRecord->status = 'paid';
                if ($paymentRecord->payment_type === 'App\Models\Recharge') {
                    $paymentRecord->paymented->billed(array('remark' => '充值', 'change_type' => 'increment'));
                }
                if ($paymentRecord->payment_type === 'App\Models\Order') {
                    $order = $paymentRecord->paymented;
                    $order->update(['status' => '0100', 'pay' => 'wechatpay']);

                    $order->book->update(['status' => '2']);

                    if ($order->type === 'EBook') {
                        $order->onwer->addContacts($order->book->onwer);
                        $order->book->onwer->addContacts($order->onwer);

                        $order->onwer->addMessage($order->book->realPath());
                    }

                }

            } else { // 用户支付失败
                $paymentRecord->status = 'paid_fail';
            }
            $paymentRecord->save(); // 保存订单
            return true; // 返回处理完成
        });

        return $response;
    }
}

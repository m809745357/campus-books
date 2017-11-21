<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Bills;
use App\Models\Traits\Payments;
use Illuminate\Database\Eloquent\SoftDeletes;
use EasyWeChat\Foundation\Application;

class Order extends Model
{
    use Bills, SoftDeletes, Payments;

    /**
     * 需要被转换成日期的属性。
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $guarded = [];

    protected static function boot()
    {
        parent::bootTraits();

        static::creating(function ($query) {
            $query->book->update(['status' => 2]);
        });
    }

    /**
     * 订单详情路径
     *
     * @return [type] [description]
     */
    public function path()
    {
        return '/orders/' . $this->id;
    }

    /**
     * 订单所属者
     *
     * @return [type] [description]
     */
    public function onwer()
    {
        return $this->belongsTo(\App\User::class, 'user_id', 'id');
    }

    /**
     * 订单属于书本
     *
     * @return [type] [description]
     */
    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id', 'id');
    }

    /**
     * 设置添加book字段时候自动序列化
     *
     * @param [type] $book [description]
     */
    public function setBookDetailAttribute($book)
    {
        return $this->attributes['book_detail'] = serialize(Book::find($book));
    }

    /**
     * 获取book字段值反序列化
     *
     * @param  [type] $book [description]
     * @return [type]       [description]
     */
    public function getBookDetailAttribute($book)
    {
        return unserialize($book);
    }

    /**
     * 设置添加address字段时候自动序列化
     *
     * @param [type] $address [description]
     */
    public function setAddressAttribute($address)
    {
        return $this->attributes['address'] = serialize(Address::find($address));
    }

    /**
     * 获取address字段值反序列化
     *
     * @param  [type] $address [description]
     * @return [type]       [description]
     */
    public function getAddressAttribute($address)
    {
        return unserialize($address);
    }

    /**
     * 取消订单
     *
     * @return [type] [description]
     */
    public function cancel()
    {
        $this->update(['status' => substr_replace($this->status, "-1", 0, 1)]);
        $this->book->update(['status' => '1']);

        // TODO:退款
        $this->billed(array('change_type' => 'increment', 'remark' => '退款'));
        $this->bills()->create([
            'user_id' => $this->book->user_id,
            'change_type' => 'decrement',
            'remark' => '退款'
        ]);

        return $this;
    }

    /**
     * 订单支付
     *
     * @return [type] [description]
     */
    public function pay()
    {
        $method = $this->getPaymentMethod();

        if ($method === 'wechatpay') {
            return $this->$method();
        }

        if (! $this->$method()) {
            return false;
        }

        $this->update(['status' => '0100', 'pay' => $method]);

        $this->book->update(['status' => '2']);

        if ($this->type === 'PBook') {
            return $this;
        }

        $this->onwer->addContacts($this->book->onwer);
        $this->book->onwer->addContacts($this->onwer);

        $this->onwer->addMessage($this->book->realPath());

        return $this;
    }

    /**
     * 微信支付
     *
     * @return [type] [description]
     */
    public function wechatpay()
    {
        $app = new Application(config('wechat'));
        $payment = $app->payment;
        $attributes = [
            'trade_type'       => 'JSAPI', // JSAPI，NATIVE，APP...
            'body'             => '资料交易',
            'detail'           => $this->title,
            'out_trade_no'     => $this->getOutTradeNo(),
            'total_fee'        => $this->price(), // 单位：分
            'notify_url'       => config('app.url') . '/wechat/notify', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            'openid'           => auth()->user()->openid, // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
            'attach'           => '书本交易记录'
        ];

        $order = new \EasyWeChat\Payment\Order($attributes);

        $result = $payment->prepare($order);

        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){
            $prepayId = $result->prepay_id;
            $this->addPaymentRecord(array(
                'out_trade_no' => $out_trade_no,
                'prepay_id' => $prepayId,
                'status' => 0
            ));

            return $payment->configForJSSDKPayment($prepayId);
        }
    }

    private function getOutTradeNo()
    {
        return config('wechat.payment.merchant_id') . date('YmdHis') . rand(1000, 9999);
    }

    /**
     * 余额支付
     *
     * @return [type] [description]
     */
    public function balances()
    {
        return $this->ifHasEnoughMoney() ? $this->payRecord() : false;
    }

    public function payRecord()
    {
        $this->billed(array('change_type' => 'decrement', 'remark' => '支付'));
        $this->bills()->create([
            'user_id' => $this->book->user_id,
            'change_type' => 'increment',
            'remark' => '收款'
        ]);

        return $this;
    }

    /**
     * 判断用户支付方式
     *
     * @return [type] [description]
     */
    public function getPaymentMethod()
    {
        return request()->paymet ?? 'balances';
    }

    /**
     * 是否具有足够多的金额支付
     *
     * @return [type] [description]
     */
    public function ifHasEnoughMoney()
    {
        return $this->onwer->balances > $this->price();
    }

    /**
     * 计算订单金额
     *
     * @return [type] [description]
     */
    public function price()
    {
        return $this->book_detail->money + $this->book_detail->freight;
    }

    /**
     * 发货
     *
     * @return [type] [description]
     */
    public function ship()
    {
        $this->update([
            'express_company' => request()->company ?? '快递公司',
            'express_number' => request()->number ?? '快递单号',
            'status' => '0110'
        ]);

        $this->book->update(['status' => '3']);

        return $this;
    }

    /**
     * 关闭交易
     * @return [type] [description]
     */
    public function close()
    {
        $this->update([
            'status' => substr_replace($this->status, "-2", 0, 1)
        ]);

        $this->book->update(['status' => '1']);

        return $this;
    }

    /**
     * 删除订单
     * @return [type] [description]
     */
    public function destory()
    {
        $this->delete();

        if (! $this->isConfirms()) {
            $this->book->update(['status' => '1']);
        }

        return $this;
    }

    /**
     * 确认订单
     * @return [type] [description]
     */
    public function confirms()
    {
        $this->update(['status' => '1110']);

        $this->book->update(['status' => '4']);

        return $this;
    }

    public function isConfirms()
    {
        return $this->status === '1110';
    }
}

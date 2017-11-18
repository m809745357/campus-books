<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Bills;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use Bills, SoftDeletes;

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

        if ($this->$method()) {
            $this->update(['status' => '0100', 'pay' => $method]);

            $this->book->update(['status' => '2']);

            $this->onwer->addMessage($this->book->realPath());

            return $this;
        }

        return false;
    }

    /**
     * 微信支付
     *
     * @return [type] [description]
     */
    public function wechatpay()
    {

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

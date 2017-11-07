<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Bills;

class Order extends Model
{
    use Bills;

    protected $guarded = [];

    protected static function boot()
    {
        parent::bootTraits();

        static::creating(function ($query) {
            $book = Book::find($query->book_detail->id);
            $book->update(['status' => 2]);
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
        $this->update(['status' => '-1000']);
        $this->book->update(['status' => '1']);

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
            return $this->update(['status' => '0100', 'pay' => $method]);
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
        return $this->ifHasEnoughMoney() ? $this->billed() : false;
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
        return $this->onwer->balances > $this->money();
    }

    /**
     * 计算订单金额
     *
     * @return [type] [description]
     */
    public function money()
    {
        return $this->book_detail->money + $this->book_detail->freight;
    }
}

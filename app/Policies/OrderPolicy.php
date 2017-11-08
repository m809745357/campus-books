<?php

namespace App\Policies;

use App\User;
use App\Models\Order;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the order.
     *
     * @param  \App\User  $user
     * @param  \App\Order  $order
     * @return mixed
     */
    public function view(User $user, Order $order)
    {
        //
    }

    /**
     * 是否有权限支付订单
     *
     * @param  User   $user  [description]
     * @param  Order  $order [description]
     * @return mixed        [description]
     */
    public function pay(User $user, Order $order)
    {
        return $order->status == '0000';
    }

    /**
     * 是否有权限发货
     *
     * @param  User   $user  [description]
     * @param  Order  $order [description]
     * @return mixed        [description]
     */
    public function ship(User $user, Order $order)
    {
        return $order->status == '0100' && $user->id == $order->book->user_id;
    }

    /**
     * 是否有权限关闭交易
     *
     * @param  User   $user  [description]
     * @param  Order  $order [description]
     * @return mixed        [description]
     */
    public function close(User $user, Order $order)
    {
        return ($order->status == '0000' || $order->status == '0100') && $user->id == $order->book->user_id;
    }

    /**
     * Determine whether the user can create orders.
     *
     * @param  User   $user  [description]
     * @param  Order  $order [description]
     * @return mixed
     */
    public function confirms(User $user, Order $order)
    {
        return $order->status == '0110' && ($user->id == $order->book->user_id || $user->id == $order->user_id);
    }

    /**
     * Determine whether the user can update the order.
     *
     * @param  \App\User  $user
     * @param  \App\Order  $order
     * @return mixed
     */
    public function update(User $user, Order $order)
    {
        return $user->id === $order->onwer->id;
    }

    /**
     * Determine whether the user can delete the order.
     *
     * @param  \App\User  $user
     * @param  \App\Order  $order
     * @return mixed
     */
    public function delete(User $user, Order $order)
    {
        return ($order->status == '-1000' || $order->status == '-1100' || $order->status == '1110') && ($user->id == $order->book->user_id || $user->id == $order->user_id );
    }
}

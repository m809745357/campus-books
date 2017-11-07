<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Book;
use App\Models\Order;
use App\Http\Requests\StoreOrderPost;

class OrderController extends Controller
{
    /**
     * [__construct description]
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 点击购买之后的订单预览页面
     *
     * @param  Category $category [description]
     * @param  Book     $book     [description]
     * @return \Illuminate\Http\Response
     */
    public function preview(Category $category, Book $book)
    {
        if (! auth()->user()->can('preview', $book)) {
            return back();
        }

        $address = auth()->user()->address->first();

        return view('orders.preview', compact('book', 'address'));
    }

    /**
     * 提交订单
     *
     * @param  StoreOrderPost $request 提交订单from验证
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderPost $request)
    {
        $book = Book::find($request->book_id);

        $this->authorize('addOrder', $book);

        $order = auth()->user()->addOrder($request->validated());

        if (request()->wantsJson()) {
            return response($order, 201);
        }

        return redirect($order->path() . '/pay');
    }

    /**
     * 订单支付页面
     *
     * @param  Order  $order [description]
     * @return \Illuminate\Http\Response
     */
    public function pay(Order $order)
    {
        if (! auth()->user()->can('pay', $order)) {
            return back();
        }

        return view('orders.pay', compact('order'));
    }

    /**
     * 订单付款
     *
     * @param  Order  $order [description]
     * @return \Illuminate\Http\Response
     */
    public function payment(Order $order)
    {
        $this->authorize('update', $order);

        if (! $order->pay()) {
            return response('支付失败', 400);
        }
    }

    public function index()
    {

    }

    /**
     * 展示单个订单
     *
     * @param  Order  $order [description]
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

    /**
     * 订单取消
     *
     * @param  Order  $order [description]
     * @return \Illuminate\Http\Response
     */
    public function cancel(Order $order)
    {
        $this->authorize('update', $order);

        return $order->cancel();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Book;
use App\Models\Order;
use App\Http\Requests\StoreOrderPost;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function preview(Category $category, Book $book)
    {
        if (! auth()->user()->can('preview', $book)) {
            return back();
        }

        $address = auth()->user()->address->first();

        return view('orders.preview', compact('book', 'address'));
    }

    public function store(StoreOrderPost $request)
    {
        $order = auth()->user()->addOrder($request->validated());

        if (request()->wantsJson()) {
            return response($order, 201);
        }

        return redirect($order->path() . '/pay');
    }

    public function pay(Order $order)
    {
        return view('orders.pay', compact('order'));
    }

    public function index()
    {

    }

    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }
}

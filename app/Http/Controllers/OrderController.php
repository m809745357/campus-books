<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Book;

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
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Book;

class BookFavoriteController extends Controller
{
    /**
     * [__construct description]
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 我的收藏
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $favorites = auth()->user()->favorited('App\\Models\\Book');
        return view('favorites.books', compact('favorites'));
    }

    /**
     * 创建
     *
     * @param  Category  $category
     * @param  Book  $book
     * @return \Illuminate\Http\Response
     */
    public function store(Category $category, Book $book)
    {
        $book->favorited();
    }

    /**
     * 删除
     *
     * @param  Category  $category
     * @param  Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destory(Category $category, Book $book)
    {
        $book->favorites->each->delete();
    }
}

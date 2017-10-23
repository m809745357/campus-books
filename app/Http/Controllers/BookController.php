<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;

class BookController extends Controller
{
    /**
     * 图书列表
     *
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        $book = Book::with('onwer', 'category')->latest();

        if ($category->exists) {
            $book->where('category_id', $category->id);
        }

        $books = $book->get();

        return view('books.index', compact('books'));
    }

    /**
     * 单个图书展示
     *
     * @param  Category $category
     * @param  Book     $book
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category, Book $book)
    {
        $book->increment('views_count');
        $book = $book->load('onwer');
        return view('books.show', compact('book'));
    }
}

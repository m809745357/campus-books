<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;

class BookController extends Controller
{
    public function index(Category $category)
    {
        $book = Book::with('onwer', 'category')->latest();

        if ($category->exists) {
            $book->where('category_id', $category->id);
        }

        $books = $book->get();

        return view('books.index', compact('books'));
    }

    public function show(Category $category, Book $book)
    {
        $book->increment('views_count');
        $book = $book->load('onwer');
        return view('books.show', compact('book'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use App\Http\Requests\StoreBookPost;
use App\Filters\BookFilters;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }
    /**
     * 图书列表
     *
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category, BookFilters $filters)
    {
        $book = Book::with('onwer', 'category')->filter($filters);

        if ($category->exists) {
            $book->where('category_id', $category->id);
        }

        if (request()->wantsJson()) {
            return response($book->paginate(10), 200);
        }

        $books = $book->paginate(10)->toJson();

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

    /**
     * 发布
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::with('childCategories', 'childCategories.childCategories')->get();
        return view('books.create', compact('categories'));
    }

    /**
     * 添加发布信息
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookPost $request)
    {
        $book = auth()->user()->books()->create(array_merge([
            'book_number' => date("YmdHis") . rand(1000, 9999)],
            $request->validated()
        ));

        if (request()->wantsJson()) {
            return response($book, 201);
        }

        return redirect($book->path());
    }
}

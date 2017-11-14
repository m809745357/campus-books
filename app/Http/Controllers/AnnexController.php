<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Book;

class AnnexController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * [index description]
     * @param  Category $category [description]
     * @param  Book     $book     [description]
     * @return [type]             [description]
     */
    public function index(Category $category, Book $book)
    {
        if (auth()->user()->can('view', $book)) {
            return view('books.annex', compact('book'));
        }

        return back();
    }

    /**
     * 下载文件
     *
     * @param  Category $category [description]
     * @param  Book     $book     [description]
     * @return [type]             [description]
     */
    public function download(Category $category, Book $book)
    {
        if (! auth()->user()->can('view', $book)) {
            return back();
        }

        if ($book->annex) {
            return redirect($book->annex);
        }

        if (\Storage::disk('public')->exists($book->pdfPath())) {
            return redirect('/storage' . $book->pdfPath());
        }

        return \PDF::loadView('books.annex', compact('book'))
            ->save($book->realPath())
            ->stream($book->downloadFileName());
    }
}

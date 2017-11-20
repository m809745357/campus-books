<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Carousel;

class CategoryController extends Controller
{
    /**
     * [index description]
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::with('childCategories.childCategories.books')->where('parent_id', 0)->latest()->get();

        $carousel = Carousel::where('type', 'category')->first();
        return view('posts.categories', compact('categories', 'carousel'));
    }
}

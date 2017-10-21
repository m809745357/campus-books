<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories =  Category::with('childCategories', 'childCategories.childCategories')->where('parent_id', 0)->latest()->get();
        return view('posts.categories', compact('categories'));
    }
}

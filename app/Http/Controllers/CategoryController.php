<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user');
    }

    public function index()
    {
        $categories = Category::withCount('posts')->paginate(10);
        return view('user.categories.index', compact('categories'));
    }

    public function show(Category $category)
    {
        $posts = $category->posts()->paginate(10);
        return view('user.categories.show', compact('category', 'posts'));
    }
}

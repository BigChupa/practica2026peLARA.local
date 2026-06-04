<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $sort = $request->query('sort');

        $query = Category::withCount('products');

        if ($sort === 'products_desc') {
            $query->orderBy('products_count', 'desc');
        } elseif ($sort === 'products_asc') {
            $query->orderBy('products_count', 'asc');
        } else {
            $query->orderBy('name');
        }

        $categories = $query->paginate(15)->appends($request->query());

        return view('admin.categories.index', compact('categories', 'sort'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->validated());

        return redirect()->route('admin.categories.show', $category)->with('success', 'Категорія успішно створена');
    }

    public function show(Category $category)
    {
        $products = $category->products()->paginate(15);
        return view('admin.categories.show', compact('category', 'products'));
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return redirect()->route('admin.categories.show', $category)->with('success', 'Категорія успішно оновлена');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Категорія успішно видалена');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user');
    }

    public function index()
    {
        $posts = auth()->user()->posts()->with('category')->paginate(10);
        return view('user.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('user.posts.create', compact('categories'));
    }

    public function store(StorePostRequest $request)
    {
        $post = Post::create(array_merge(
            $request->validated(),
            ['user_id' => auth()->id()]
        ));

        return redirect()->route('posts.show', $post)->with('success', 'Пост успішно створено');
    }

    public function show(Post $post)
    {
        return view('user.posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        $categories = Category::all();
        return view('user.posts.edit', compact('post', 'categories'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $this->authorize('update', $post);
        
        $post->update($request->validated());

        return redirect()->route('posts.show', $post)->with('success', 'Пост успішно оновлено');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Пост успішно видалено');
    }
}

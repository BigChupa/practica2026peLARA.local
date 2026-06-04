<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $query = User::withCount('posts');
        $searchType = $request->query('search_type', 'name');

        if ($request->filled('search')) {
            $searchTerm = $request->search;

            if ($searchType === 'email') {
                $query->where('email', 'like', '%' . $searchTerm . '%');
            } else {
                $query->where('name', 'like', '%' . $searchTerm . '%');
            }
        }

        $users = $query->paginate(15);

        return view('admin.users.index', compact('users', 'searchType'));
    }

    public function show(User $user)
    {
        $posts = $user->posts()->paginate(10);
        return view('admin.users.show', compact('user', 'posts'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
            'role' => 'sometimes|required|in:admin,user',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.show', $user)->with('success', 'Користувача успішно оновлено');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Ви не можете видалити себе');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Користувача успішно видалено');
    }
}

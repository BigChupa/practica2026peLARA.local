<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user');
    }

    public function show(User $user)
    {
        $posts = $user->posts()->paginate(10);
        return view('user.users.show', compact('user', 'posts'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('user.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);
        $action = $request->input('action', 'profile');

        if ($action === 'profile') {
            $validated = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
            ]);

            $update = [];
            if ($request->filled('name')) $update['name'] = $request->input('name');
            if ($request->filled('email')) $update['email'] = $request->input('email');
            if (!empty($update)) $user->update($update);

            $user->save();

            return back()->with('success', 'Основна інформація оновлена');
        }

        if ($action === 'password') {
            $validated = $request->validate([
                'password' => 'required|string|min:8|confirmed'
            ]);

            $user->password = bcrypt($request->input('password'));
            $user->save();

            return back()->with('success', 'Пароль оновлено');
        }

        if ($action === 'avatar') {
            try {
                $file = $request->file('avatar');
                Log::info('Avatar upload attempt', [
                    'hasFile' => $request->hasFile('avatar'),
                    'file_original_name' => $file ? $file->getClientOriginalName() : null,
                    'file_mime' => $file ? $file->getClientMimeType() : null,
                    'file_size' => $file ? $file->getSize() : null,
                    'request_keys' => array_keys($request->all())
                ]);
            } catch (\Throwable $e) {
                Log::error('Error logging avatar upload: ' . $e->getMessage());
            }

            $validated = $request->validate([
                'avatar' => 'nullable|image|max:2048',
                'delete_avatar' => 'nullable|boolean'
            ]);

            if ($request->filled('delete_avatar')) {
                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                    $user->avatar = null;
                }
            }

            if ($request->hasFile('avatar')) {
                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                }
                $path = $request->file('avatar')->store('avatars', 'public');
                $user->avatar = $path;
            }

            $user->save();

            return back()->with('success', 'Аватар оновлено');
        }

        return back();
    }
}

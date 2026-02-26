@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>{{ $user->name }}</h2>
            <p class="text-muted">
                Email: <strong>{{ $user->email }}</strong> |
                Роль: <strong>{{ $user->isAdmin() ? 'Адмін' : 'Користувач' }}</strong> |
                Зареєстровано: {{ $user->created_at->format('d.m.Y H:i') }}
            </p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary me-2">В адмін-панель</a>
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Редагувати
            </a>
            @if ($user->id !== auth()->id())
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Ви впевнені?')">
                        <i class="fas fa-trash"></i> Видалити
                    </button>
                </form>
            @endif
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Назад
            </a>
        </div>
    </div>

    <h4>Пости користувача ({{ $posts->total() }})</h4>
    
    @if ($posts->count())
        <div class="row">
            @foreach ($posts as $post)
                <div class="col-md-12 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="{{ route('admin.posts.show', $post) }}">{{ $post->title }}</a>
                            </h5>
                            <p class="card-text text-muted small">
                                Категорія: <strong>{{ $post->category->name }}</strong> |
                                Створено: {{ $post->created_at->format('d.m.Y H:i') }}
                            </p>
                            <p class="card-text">{{ Str::limit($post->content, 100) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{ $posts->links() }}
    @else
        <div class="alert alert-info">Користувач ще не створив жодного поста</div>
    @endif
</div>
@endsection

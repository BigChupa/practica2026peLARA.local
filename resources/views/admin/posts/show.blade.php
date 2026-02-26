@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>{{ $post->title }}</h2>
            <p class="text-muted">
                Автор: <strong>{{ $post->user->name }}</strong> | 
                Категорія: <strong>{{ $post->category->name }}</strong> |
                Створено: {{ $post->created_at->format('d.m.Y H:i') }}
                @if ($post->updated_at !== $post->created_at)
                    | Оновлено: {{ $post->updated_at->format('d.m.Y H:i') }}
                @endif
            </p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Редагувати
            </a>
            <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Ви впевнені?')">
                    <i class="fas fa-trash"></i> Видалити
                </button>
            </form>
            <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Назад
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="content">
                {!! nl2br(e($post->content)) !!}
            </div>
        </div>
    </div>
</div>
@endsection

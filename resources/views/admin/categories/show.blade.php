@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>{{ $category->name }}</h2>
            <p class="text-muted">{{ $category->description }}</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Редагувати
            </a>
            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Ви впевнені?')">
                    <i class="fas fa-trash"></i> Видалити
                </button>
            </form>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Назад
            </a>
        </div>
    </div>

    <h4>Пости в цій категорії ({{ $posts->total() }})</h4>
    
    @if ($posts->count())
        <div class="row">
            @foreach ($posts as $post)
                <div class="col-md-12 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $post->title }}</h5>
                            <p class="card-text text-muted small">
                                Автор: <strong>{{ $post->user->name }}</strong> |
                                Створено: {{ $post->created_at->format('d.m.Y H:i') }}
                            </p>
                            <p class="card-text">{{ Str::limit($post->content, 100) }}</p>
                            <a href="{{ route('admin.posts.show', $post) }}" class="btn btn-sm btn-info">Переглянути</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{ $posts->links() }}
    @else
        <div class="alert alert-info">Постів в цій категорії немає</div>
    @endif
</div>
@endsection

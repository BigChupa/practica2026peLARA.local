@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>{{ $category->name }}</h2>
            <p class="text-muted">{{ $category->description }}</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">
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
                            <h5 class="card-title">
                                <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                            </h5>
                            <p class="card-text text-muted small">
                                Автор: <strong>{{ $post->user->name }}</strong> |
                                Створено: {{ $post->created_at->format('d.m.Y H:i') }}
                            </p>
                            <p class="card-text">{{ Str::limit($post->content, 150) }}</p>
                            <a href="{{ route('posts.show', $post) }}" class="btn btn-sm btn-primary">Прочитати</a>
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

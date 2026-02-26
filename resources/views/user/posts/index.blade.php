@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>Мої Пости</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('posts.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Новий пост
            </a>
        </div>
    </div>

    @if ($posts->count())
        <div class="row">
            @foreach ($posts as $post)
                <div class="col-md-12 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <h5 class="card-title">
                                        <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                                    </h5>
                                    <p class="card-text text-muted small">
                                        Категорія: <strong>{{ $post->category->name }}</strong>
                                        | Створено: {{ $post->created_at->format('d.m.Y H:i') }}
                                    </p>
                                    <p class="card-text">
                                        {{ Str::limit($post->content, 150) }}
                                    </p>
                                </div>
                                <div class="col-md-4 text-end">
                                    <a href="{{ route('posts.show', $post) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Переглянути
                                    </a>
                                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Редагувати
                                    </a>
                                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Ви впевнені?')">
                                            <i class="fas fa-trash"></i> Видалити
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                {{ $posts->links() }}
            </div>
        </div>
    @else
        <div class="alert alert-info" role="alert">
            <h4 class="alert-heading">Постів не знайдено</h4>
            <p>У вас ще немає постів. <a href="{{ route('posts.create') }}">Створіть свій перший пост</a></p>
        </div>
    @endif
</div>
@endsection

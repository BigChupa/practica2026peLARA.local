@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-3 text-center">
            @if($user->avatar)
                <img src="/{{ 'storage/app/public/' . $user->avatar }}" class="rounded-circle mb-2" style="width:120px;height:120px;object-fit:cover">
            @else
                <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim($user->email))) }}?s=120&d=mp" class="rounded-circle mb-2" style="width:120px;height:120px;object-fit:cover">
            @endif
            @if(auth()->id() === $user->id)
                <div class="mt-2">
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-primary">Редагувати</a>
                </div>
            @endif
        </div>

        <div class="col-md-9">
            <h2>{{ $user->name }}</h2>
            <p class="text-muted mb-1">Email: <strong>{{ $user->email }}</strong></p>
            <p class="text-muted">Зареєстровано: {{ $user->created_at->format('d.m.Y H:i') }}</p>
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
                                <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                            </h5>
                            <p class="card-text text-muted small">
                                Категорія: <strong>{{ $post->category->name }}</strong> |
                                Створено: {{ $post->created_at->format('d.m.Y H:i') }}
                            </p>
                            <p class="card-text">{{ Str::limit($post->content, 150) }}</p>
                            <a href="{{ route('posts.show', $post) }}" class="btn btn-sm btn-info">Прочитати</a>
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

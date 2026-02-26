@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-file-alt"></i> Управління Постами</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.posts.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Новий пост
            </a>
        </div>
    </div>

    @if ($posts->count())
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Заголовок</th>
                        <th>Автор</th>
                        <th>Категорія</th>
                        <th>Дата</th>
                        <th>Дії</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                        <tr>
                            <td>
                                <a href="{{ route('admin.posts.show', $post) }}">{{ $post->title }}</a>
                            </td>
                            <td>
                                <a href="{{ route('admin.users.show', $post->user) }}">{{ $post->user->name }}</a>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $post->category->name }}</span>
                            </td>
                            <td>{{ $post->created_at->format('d.m.Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.posts.show', $post) }}" class="btn btn-sm btn-info" title="Переглянути">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-warning" title="Редагувати">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Видалити" onclick="return confirm('Ви впевнені?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                {{ $posts->links() }}
            </div>
        </div>
    @else
        <div class="alert alert-info" role="alert">
            <h4 class="alert-heading">Постів не знайдено</h4>
            <p>Немає постів в системі. <a href="{{ route('admin.posts.create') }}">Створіть новий пост</a></p>
        </div>
    @endif
</div>
@endsection

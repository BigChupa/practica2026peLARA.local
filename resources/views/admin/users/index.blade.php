@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-users"></i> Управління Користувачами</h2>
        </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">В адмін-панель</a>
            </div>
    </div>

    @if ($users->count())
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Ім'я</th>
                        <th>Email</th>
                        <th>Роль</th>
                        <th>Постів</th>
                        <th>Зареєстровано</th>
                        <th>Дії</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if ($user->isAdmin())
                                    <span class="badge bg-danger">Адмін</span>
                                @else
                                    <span class="badge bg-success">Користувач</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $user->posts_count }}</span>
                            </td>
                            <td>{{ $user->created_at->format('d.m.Y') }}</td>
                            <td>
                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-info" title="Переглянути">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning" title="Редагувати">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if ($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Видалити" onclick="return confirm('Ви впевнені?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                {{ $users->links('vendor.pagination.simple-custom') }}
            </div>
        </div>
    @else
        <div class="alert alert-info" role="alert">
            <h4 class="alert-heading">Користувачів не знайдено</h4>
        </div>
    @endif
</div>
@endsection

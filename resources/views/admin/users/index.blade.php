@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-users"></i> Управління Користувачами</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">В адмін-панель</a>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <form action="{{ url()->current() }}" method="GET" class="row g-2">
                <div class="col-md-3">
                    <select name="search_type" class="form-select">
                        <option value="name" {{ request('search_type', 'name') === 'name' ? 'selected' : '' }}>Пошук за ім'ям</option>
                        <option value="email" {{ request('search_type') === 'email' ? 'selected' : '' }}>Пошук за email</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <input 
                        type="text" 
                        name="search" 
                        class="form-control" 
                        placeholder="Введіть ім'я або email..." 
                        value="{{ request('search') }}"
                    >
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1">Знайти</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary flex-grow-1">Скинути</a>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Ім'я</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Постів</th>
                    <th>Зареєстровано</th>
                    <th>Дії</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
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
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-3">
                            <div class="text-muted">Користувачів за таким запитом не знайдено</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($users->hasPages())
        <div class="row mt-4">
            <div class="col-md-12">
                {{ $users->appends(['search' => request('search'), 'search_type' => request('search_type')])->links('vendor.pagination.simple-custom') }}
            </div>
        </div>
    @endif
</div>
@endsection
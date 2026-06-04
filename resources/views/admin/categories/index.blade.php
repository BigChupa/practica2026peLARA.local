@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-list"></i> Управління Категоріями</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary me-2">В адмін-панель</a>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Нова категорія
            </a>
        </div>
    </div>

    @if ($categories->count())
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Назва</th>
                        <th>Описання</th>
                        <th>
                            @php
                                $nextSort = request('sort') === 'products_desc' ? 'products_asc' : 'products_desc';
                            @endphp
                            <a href="{{ route('admin.categories.index', array_merge(request()->query(), ['sort' => $nextSort])) }}" class="text-white text-decoration-none">
                                Товарів
                                @if(request('sort') === 'products_desc')
                                    <i class="fas fa-sort-amount-down-alt ms-1"></i>
                                @elseif(request('sort') === 'products_asc')
                                    <i class="fas fa-sort-amount-up-alt ms-1"></i>
                                @else
                                    <i class="fas fa-sort ms-1"></i>
                                @endif
                            </a>
                        </th>
                        <th>Дії</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>{{ Str::limit($category->description, 50) }}</td>
                            <td>
                                <span class="badge bg-primary">{{ $category->products_count }}</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-sm btn-info" title="Переглянути">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-warning" title="Редагувати">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline">
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
                {{ $categories->links('vendor.pagination.simple-custom') }}
            </div>
        </div>
    @else
        <div class="alert alert-info" role="alert">
            <h4 class="alert-heading">Категорій не знайдено</h4>
            <p>Немає категорій в системі. <a href="{{ route('admin.categories.create') }}">Створіть нову категорію</a></p>
        </div>
    @endif
</div>
@endsection

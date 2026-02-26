@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2><i class="fas fa-list"></i> Категорії</h2>
        </div>
    </div>

    @if ($categories->count())
        <div class="row">
            @foreach ($categories as $category)
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="{{ route('categories.show', $category) }}">{{ $category->name }}</a>
                            </h5>
                            <p class="card-text text-muted">{{ Str::limit($category->description, 100) }}</p>
                            <p class="card-text">
                                <small class="text-muted">
                                    <i class="fas fa-file-alt"></i> Постів: <strong>{{ $category->posts_count }}</strong>
                                </small>
                            </p>
                            <a href="{{ route('categories.show', $category) }}" class="btn btn-sm btn-primary">
                                Переглянути
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                {{ $categories->links() }}
            </div>
        </div>
    @else
        <div class="alert alert-info" role="alert">
            <h4 class="alert-heading">Категорій не знайдено</h4>
        </div>
    @endif
</div>
@endsection

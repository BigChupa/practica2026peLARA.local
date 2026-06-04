@extends('layouts.app')

@section('content')
<div class="container mt-5">
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

    <h4>Товари в цій категорії ({{ $products->total() }})</h4>
    
    @if ($products->count())
        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Назва</th>
                        <th>SKU</th>
                        <th>Ціна</th>
                        <th>Залишок</th>
                        <th>Дії</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td><strong>{{ $product->name }}</strong></td>
                            <td><code>{{ $product->sku }}</code></td>
                            <td>₴ {{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->stock_quantity }}</td>
                            <td>
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $products->links('vendor.pagination.simple-custom') }}
    @else
        <div class="alert alert-info">Товарів в цій категорії немає</div>
    @endif
</div>
@endsection

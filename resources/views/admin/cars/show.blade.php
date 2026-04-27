@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>{{ $car->make }} {{ $car->model }} ({{ $car->year }})</h2>
            <p class="text-muted">
                VIN: <code>{{ $car->vin }}</code> | 
                @if($car->trim)
                    Комплектація: <strong>{{ $car->trim }}</strong> |
                @endif
                Додано: {{ $car->created_at->format('d.m.Y H:i') }}
            </p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary me-2">В адмін-панель</a>
            <a href="{{ route('admin.cars.edit', $car) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Редагувати
            </a>
            <form action="{{ route('admin.cars.destroy', $car) }}" method="POST" style="display:inline" onsubmit="return confirm('Ви впевнені? Це видалить автомобіль і розпочне видалення його зв\'язків.')">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">
                    <i class="fas fa-trash"></i> Видалити
                </button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-light">
                    <h5>Інформація про авто</h5>
                </div>
                <div class="card-body">
                    <p><strong>Марка:</strong> {{ $car->make }}</p>
                    <p><strong>Модель:</strong> {{ $car->model }}</p>
                    <p><strong>Рік:</strong> {{ $car->year }}</p>
                    @if($car->trim)
                        <p><strong>Комплектація:</strong> {{ $car->trim }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-light d-flex justify-content-between">
                    <h5>Пов'язані товари</h5>
                    <span class="badge bg-info">{{ $car->products->count() }}</span>
                </div>
                <div class="card-body">
                    @if($car->products->count())
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th>Назва</th>
                                        <th>SKU</th>
                                        <th>Ціна</th>
                                        <th>Залишок</th>
                                        <th>Дії</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($car->products as $product)
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
                    @else
                        <p class="text-muted text-center py-3">
                            <i class="fas fa-inbox"></i> Немає товарів для цього автомобіля.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

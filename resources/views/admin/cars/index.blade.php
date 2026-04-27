@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-car"></i> Управління Автомобілями</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary me-2">В адмін-панель</a>
            <a href="{{ route('admin.cars.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Новий автомобіль
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($cars->count())
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Марка</th>
                        <th>Модель</th>
                        <th>Рік</th>
                        <th>VIN</th>
                        <th>Комплектація</th>
                        <th>Товарів</th>
                        <th>Дії</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cars as $car)
                        <tr>
                            <td><strong>{{ $car->make }}</strong></td>
                            <td>{{ $car->model }}</td>
                            <td>{{ $car->year }}</td>
                            <td><code>{{ Str::limit($car->vin, 10) }}</code></td>
                            <td>{{ $car->trim ?? '—' }}</td>
                            <td><span class="badge bg-info">{{ $car->products->count() }}</span></td>
                            <td>
                                <a href="{{ route('admin.cars.show', $car) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.cars.edit', $car) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.cars.destroy', $car) }}" method="POST" style="display:inline" onsubmit="return confirm('Ви впевнені?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">
            {{ $cars->links() }}
        </div>
    @else
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> Немає автомобілів. <a href="{{ route('admin.cars.create') }}">Додати першого</a>
        </div>
    @endif
</div>
@endsection

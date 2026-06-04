@extends('layouts.app')

@section('content')
<div class="container mt-5">
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

    <div class="card mb-4 bg-light">
        <div class="card-body">
            <form action="{{ url()->current() }}" method="GET" id="filter-form" class="row g-3 align-items-end">
                
                <div class="col-md-3">
                    <label for="make" class="form-label small fw-bold">Марка</label>
                    <select name="make" id="make" class="form-select">
                        <option value="">Всі марки</option>
                        @foreach ($makes as $make)
                            <option value="{{ $make }}" {{ request('make') == $make ? 'selected' : '' }}>
                                {{ $make }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="model" class="form-label small fw-bold">Модель</label>
                    <select name="model" id="model" class="form-select" {{ request('make') ? '' : 'disabled' }}>
                        <option value="">Всі моделі</option>
                        @foreach ($models as $modelItem)
                            <option value="{{ $modelItem->model }}" 
                                    data-make="{{ $modelItem->make }}" 
                                    {{ request('model') == $modelItem->model ? 'selected' : '' }}
                                    style="{{ request('make') == $modelItem->make ? '' : 'display: none;' }}">
                                {{ $modelItem->model }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="year" class="form-label small fw-bold">Рік</label>
                    <select name="year" id="year" class="form-select">
                        <option value="">Всі роки</option>
                        @foreach ($years as $year)
                            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1">
                        <i class="fas fa-search"></i> Знайти
                    </button>
                    <a href="{{ url()->current() }}" class="btn btn-outline-primary">
                        <i class="fas fa-times"></i> Скинути
                    </a>
                </div>

            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Марка</th>
                    <th>Модель</th>
                    <th>Рік</th>
                    <th>Комплектація</th>
                    <th>
                        @php
                            $nextSort = request('sort') === 'products_desc' ? 'products_asc' : 'products_desc';
                        @endphp
                        <a href="{{ route('admin.cars.index', array_merge(request()->query(), ['sort' => $nextSort])) }}" class="text-white text-decoration-none">
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
                @forelse ($cars as $car)
                    <tr>
                        <td><strong>{{ $car->make }}</strong></td>
                        <td>{{ $car->model }}</td>
                        <td>{{ $car->year }}</td>
                        <td>{{ $car->trim ?? '—' }}</td>
                        <td><span class="badge bg-info">{{ $car->products_count }}</span></td>
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
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-3 text-muted">
                            Автомобілів за вказаними критеріями не знайдено.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $cars->appends(request()->query())->links('vendor.pagination.simple-custom') }}
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const makeSelect = document.getElementById('make');
    const modelSelect = document.getElementById('model');
    const modelOptions = Array.from(modelSelect.options);

    makeSelect.addEventListener('change', function () {
        const selectedMake = this.value;

        // Очищуємо обрану модель при зміні марки
        modelSelect.value = "";

        if (selectedMake === "") {
            // Якщо марку скинуто, блокуємо селект моделей
            modelSelect.disabled = true;
            modelOptions.forEach(option => {
                if (option.value === "") option.style.display = 'block';
                else option.style.display = 'none';
            });
        } else {
            // Активуємо селект та фільтруємо моделі за атрибутом data-make
            modelSelect.disabled = false;
            modelOptions.forEach(option => {
                const optionMake = option.getAttribute('data-make');
                if (option.value === "" || optionMake === selectedMake) {
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none';
                }
            });
        }
    });
});
</script>
@endsection
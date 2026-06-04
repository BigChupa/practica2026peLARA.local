@extends('layouts.admin')

@section('admin-content')
  <div class="d-flex justify-content-between align-items-start mb-3">
    <div>
      <h2>{{ $product->name }}</h2>
      <p class="text-muted mb-0">SKU: {{ $product->sku }}</p>
      <p class="text-muted mb-0">Категорія: {{ $product->category->name ?? 'Без категорії' }}</p>
    </div>
    <div>
      <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary me-2">Назад до товарів</a>
      <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning">Редагувати</a>
    </div>
  </div>

  <div class="card mb-4">
    <div class="row g-0">
      <div class="col-md-4">
        <img src="{{ $product->image_path ? asset('storage/' . $product->image_path) : asset('storage/image/121.png') }}" class="img-fluid rounded-start" alt="{{ $product->name }}">
      </div>
      <div class="col-md-8">
        <div class="card-body">
          <h5 class="card-title">Інформація про товар</h5>
          <p class="card-text">{{ $product->description ?: 'Опис товару відсутній.' }}</p>
          <div class="row">
            <div class="col-md-6">
              <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Ціна:</strong> ₴{{ number_format($product->price, 2, ',', ' ') }}</li>
                <li class="list-group-item"><strong>Наявність:</strong> {{ $product->stock_quantity }} шт.</li>
                <li class="list-group-item"><strong>SKU:</strong> {{ $product->sku }}</li>
              </ul>
            </div>
            <div class="col-md-6">
              <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Авто:</strong> {{ $product->car ? $product->car->make . ' ' . $product->car->model . ' (' . $product->car->year . ')' : 'Не вказано' }}</li>
                <li class="list-group-item"><strong>Сумісність:</strong> {{ $product->compatible_make ? $product->compatible_make . ' ' . $product->compatible_model . ' ' . $product->compatible_year : 'Не вказано' }}</li>
                <li class="list-group-item"><strong>Додано:</strong> {{ $product->created_at->format('d.m.Y H:i') }}</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Додаткові дані</h5>
          <p class="mb-1"><strong>ID:</strong> {{ $product->id }}</p>
          <p class="mb-1"><strong>Category ID:</strong> {{ $product->category_id ?? '—' }}</p>
          <p class="mb-1"><strong>Car ID:</strong> {{ $product->car_id ?? '—' }}</p>
          <p class="mb-1"><strong>Оновлено:</strong> {{ $product->updated_at->format('d.m.Y H:i') }}</p>
        </div>
      </div>
    </div>
  </div>
@endsection
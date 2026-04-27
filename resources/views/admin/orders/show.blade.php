@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <div class="row mb-4">
    <div class="col-md-8">
      <h2>Замовлення #{{ $order->id }}</h2>
    </div>
    <div class="col-md-4 text-end">
      <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Назад до замовлень
      </a>
    </div>
  </div>

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <div class="row">
    <!-- Order Information -->
    <div class="col-md-6">
      <div class="card mb-4">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">Інформація про замовлення</h5>
        </div>
        <div class="card-body">
          <p><strong>ID замовлення:</strong> #{{ $order->id }}</p>
          <p><strong>Дата:</strong> {{ $order->order_date->format('d.m.Y H:i') }}</p>
          <p><strong>Сума:</strong> <span class="badge bg-success fs-6">₴{{ number_format($order->total_amount, 2, ',', ' ') }}</span></p>
          
          <hr>

          <p><strong>Клієнт:</strong></p>
          <p>
            {{ $order->user->name ?? 'Невідомо' }}<br>
            <small class="text-muted">{{ $order->user->email ?? '' }}</small>
          </p>
        </div>
      </div>
    </div>

    <!-- Status Update -->
    <div class="col-md-6">
      <div class="card mb-4">
        <div class="card-header bg-info text-white">
          <h5 class="mb-0">Статус замовлення</h5>
        </div>
        <div class="card-body">
          <form action="{{ route('admin.orders.update', $order) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
              <label for="status" class="form-label"><strong>Поточний статус</strong></label>
              <select name="status" id="status" class="form-select">
                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Очікування</option>
                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Обробка</option>
                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Завершено</option>
                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Скасовано</option>
              </select>
            </div>

            <button type="submit" class="btn btn-warning w-100">
              <i class="fas fa-save"></i> Оновити статус
            </button>
          </form>

          <hr>

          <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Ви впевнені?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger w-100">
              <i class="fas fa-trash"></i> Видалити замовлення
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Order Items -->
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header bg-secondary text-white">
          <h5 class="mb-0">Товари в замовленні</h5>
        </div>
        <div class="card-body">
          @if($order->products->isEmpty())
            <p class="text-muted">Немає товарів у цьому замовленні.</p>
          @else
            <div class="table-responsive">
              <table class="table">
                <thead class="table-light">
                  <tr>
                    <th>Назва товару</th>
                    <th>Категорія</th>
                    <th>Кількість</th>
                    <th>Ціна за один</th>
                    <th>Сума</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($order->products as $product)
                    <tr>
                      <td>
                        <strong>{{ $product->name }}</strong>
                        @if($product->image_path)
                          <br>
                          <img src="/{{ 'storage/app/public/' . $product->image_path }}" alt="{{ $product->name }}" style="max-width: 50px; height: auto;">
                        @else
                          <br>
                          <img src="{{ asset('storage/image/121.png') }}" alt="{{ $product->name }}" style="max-width: 50px; height: auto;">
                        @endif
                      </td>
                      <td>
                        <span class="badge bg-info">{{ $product->category->name ?? 'Без категорії' }}</span>
                      </td>
                      <td>{{ $product->pivot->quantity }}</td>
                      <td>₴{{ number_format($product->pivot->price, 2, ',', ' ') }}</td>
                      <td><strong>₴{{ number_format($product->pivot->quantity * $product->pivot->price, 2, ',', ' ') }}</strong></td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

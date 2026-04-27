@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <div class="row mb-4">
    <div class="col-md-8">
      <h2>Замовлення</h2>
    </div>
    <div class="col-md-4 text-end">
      <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary me-2">В адмін-панель</a>
    </div>
  </div>

  @if($orders->isEmpty())
    <div class="alert alert-info">
      <i class="fas fa-info-circle"></i> Немає замовлень.
    </div>
  @else
    <div class="table-responsive">
      <table class="table table-hover">
        <thead class="table-light">
          <tr>
            <th>ID</th>
            <th>Клієнт</th>
            <th>Товари</th>
            <th>Сума</th>
            <th>Статус</th>
            <th>Дата</th>
            <th>Дія</th>
          </tr>
        </thead>
        <tbody>
          @foreach($orders as $order)
            <tr>
              <td><strong>#{{ $order->id }}</strong></td>
              <td>
                {{ $order->user->name ?? 'Невідомо' }}
                <br>
                <small class="text-muted">{{ $order->user->email ?? '' }}</small>
              </td>
              <td>
                {{ $order->products->count() }} товарів
              </td>
              <td><strong>₴{{ number_format($order->total_amount, 2, ',', ' ') }}</strong></td>
              <td>
                @if($order->status === 'pending')
                  <span class="badge bg-warning">Очікування</span>
                @elseif($order->status === 'processing')
                  <span class="badge bg-info">Обробка</span>
                @elseif($order->status === 'completed')
                  <span class="badge bg-success">Завершено</span>
                @else
                  <span class="badge bg-danger">Скасовано</span>
                @endif
              </td>
              <td>{{ $order->order_date->format('d.m.Y H:i') }}</td>
              <td>
                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary">
                  <i class="fas fa-eye"></i>
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
      {{ $orders->links('vendor.pagination.simple-custom') }}
    </div>
  @endif
</div>
@endsection

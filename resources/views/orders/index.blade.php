@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <div class="row mb-4">
    <div class="col-md-8">
      <h2>Мої замовлення</h2>
    </div>
    <div class="col-md-4 text-end">
      <a href="{{ route('shop ') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> На головну
      </a>
    </div>
  </div>

  @if(Auth::guest())
    <div class="alert alert-warning">
      <i class="fas fa-info-circle"></i> 
      <a href="{{ route('login') }}">Увійдіть</a>, щоб переглянути свої замовлення.
    </div>
  @elseif($orders->isEmpty())
    <div class="alert alert-info">
      <i class="fas fa-info-circle"></i> У вас немає замовлень.
    </div>
  @else
    <div class="table-responsive">
      <table class="table table-hover">
        <thead class="table-light">
          <tr>
            <th>№ Замовлення</th>
            <th>Дата</th>
            <th>Товари</th>
            <th>Загальна сума</th>
            <th>Статус</th>
            <th>Дія</th>
          </tr>
        </thead>
        <tbody>
          @foreach($orders as $order)
            <tr>
              <td><strong>#{{ $order->id }}</strong></td>
              <td>{{ $order->order_date->format('d.m.Y H:i') }}</td>
              <td>{{ $order->products->count() }} товар(и)</td>
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
              <td>
                <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-primary">
                  <i class="fas fa-eye"></i> Деталі
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
      {{ $orders->links() }}
    </div>
  @endif
</div>
@endsection

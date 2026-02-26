@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <div class="row mb-4">
    <div class="col-md-8">
      <h2>Замовлення #{{ $order->id }}</h2>
    </div>
    <div class="col-md-4 text-end">
      <a href="{{ route('orders.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Мої замовлення
      </a>
    </div>
  </div>

  @guest
    <div class="alert alert-warning">
      <i class="fas fa-info-circle"></i> 
      <a href="{{ route('login') }}">Увійдіть</a>, щоб переглянути замовлення.
    </div>
  @else
    @if(auth()->user()->id !== $order->user_id)
      <div class="alert alert-danger">
        <i class="fas fa-exclamation-triangle"></i> Ви не маєте доступу до цього замовлення.
      </div>
    @else
      <div class="row">
        <div class="col-md-6">
          <div class="card mb-4">
            <div class="card-header bg-primary text-white">
              <h5 class="mb-0">Інформація про замовлення</h5>
            </div>
            <div class="card-body">
              <p><strong>ID замовлення:</strong> #{{ $order->id }}</p>
              <p><strong>Дата:</strong> {{ $order->order_date->format('d.m.Y H:i') }}</p>
              <p><strong>Загальна сума:</strong> <span class="badge bg-success fs-6">₴{{ number_format($order->total_amount, 2, ',', ' ') }}</span></p>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card mb-4">
            <div class="card-header bg-info text-white">
              <h5 class="mb-0">Статус</h5>
            </div>
            <div class="card-body">
              @if($order->status === 'pending')
                <p><span class="badge bg-warning fs-6">Очікування</span></p>
                <small class="text-muted">Ваше замовлення очікує на обробку... Ми зв'яжемося з вами найближчим часом.</small>
              @elseif($order->status === 'processing')
                <p><span class="badge bg-info fs-6">Обробка</span></p>
                <small class="text-muted">Ваше замовлення обробляється. Дякуємо за терпіння!</small>
              @elseif($order->status === 'completed')
                <p><span class="badge bg-success fs-6">Завершено</span></p>
                <small class="text-muted">Ваше замовлення успішно завершено. Спасибі за покупку!</small>
              @else
                <p><span class="badge bg-danger fs-6">Скасовано</span></p>
                <small class="text-muted">Це замовлення було скасовано.</small>
              @endif
            </div>
          </div>
        </div>
      </div>

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
                              <img src="/{{ 'storage/' . $product->image_path }}" alt="{{ $product->name }}" style="max-width: 50px; height: auto;">
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
                    <tfoot>
                      <tr class="table-light">
                        <td colspan="4" class="text-end"><strong>РАЗОМ:</strong></td>
                        <td><strong>₴{{ number_format($order->total_amount, 2, ',', ' ') }}</strong></td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    @endif
  @endguest
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Оформлення замовлення</h1>

    @if($items->isEmpty())
        <div class="alert alert-info">Ваш кошик порожній.</div>
        <a href="{{ route('shop') }}" class="btn btn-primary">Повернутись до магазину</a>
    @else
        <div class="row">
            <div class="col-md-7">
                <form method="POST" action="{{ route('checkout.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Ім'я</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', auth()->check() ? auth()->user()->name : '') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', auth()->check() ? auth()->user()->email : '') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Телефон</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Доставка</label>
                        <select name="delivery" class="form-select" required>
                            <option value="nova">Нова Пошта</option>
                            <option value="ukr">Укрпошта</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Деталі доставки (відділення або адреса)</label>
                        <input type="text" name="delivery_details" class="form-control" value="{{ old('delivery_details') }}">
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn btn-success">Підтвердити замовлення (оплата банківським переказом)</button>
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">Повернутись до кошика</a>
                    </div>
                </form>
            </div>
            <div class="col-md-5">
                <h5>Огляд замовлення</h5>
                <ul class="list-group mb-3">
                    @php $subtotal = 0; @endphp
                    @foreach($items as $item)
                        @php $line = $item->product->price * $item->quantity; $subtotal += $line; @endphp
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div>
                                <div class="fw-bold">{{ $item->product->name }}</div>
                                <div class="text-muted small">x{{ $item->quantity }}</div>
                            </div>
                            <div>₴ {{ number_format($line, 2, ',', ' ') }}</div>
                        </li>
                    @endforeach
                    <li class="list-group-item d-flex justify-content-between">
                        <strong>Разом</strong>
                        <strong>₴ {{ number_format($subtotal, 2, ',', ' ') }}</strong>
                    </li>
                </ul>
                <div class="alert alert-info">
                    Оплата: банківський переказ за реквізитами після підтвердження замовлення.
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

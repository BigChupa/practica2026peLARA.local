@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Дякуємо за замовлення №{{ $order->id }}</h1>

    <div class="row">
        <div class="col-md-8">
            <h5>Контактні дані</h5>
            <p><strong>Ім'я:</strong> {{ $contact['name'] ?? '-' }}</p>
            <p><strong>Email:</strong> {{ $contact['email'] ?? '-' }}</p>
            <p><strong>Телефон:</strong> {{ $contact['phone'] ?? '-' }}</p>

            <h5>Доставка</h5>
            <p>
                <strong>Компанія:</strong> {{ $order->delivery_service === 'nova_poshta' ? 'Нова Пошта' : 'Укрпошта' }}<br>
                <strong>Тип:</strong> 
                @if($order->delivery_type === 'post_office')
                    Відділення
                @elseif($order->delivery_type === 'postomat')
                    Поштомат
                @else
                    Кур'єр на адресу
                @endif
                <br>
                <strong>Місто:</strong> {{ $order->delivery_city }}<br>
                <strong>Адреса:</strong> {{ $order->delivery_address }}
            </p>

            <h5>Оплата — банківський переказ</h5>
            <p>Ваші товари зарезервовані на складі. Будь ласка, перекажіть суму замовлення на наступні реквізити протягом 30 хвилин:</p>
            <ul>
                <li><strong>Отримувач:</strong> {{ $bank['recipient'] }}</li>
                <li><strong>Банк:</strong> {{ $bank['bank'] }}</li>
                <li><strong>IBAN:</strong> {{ $bank['iban'] }}</li>
                <li><strong>MFO:</strong> {{ $bank['mfo'] }}</li>
                <li><strong>Призначення платежу:</strong> {{ $bank['note'] }}</li>
            </ul>
            <p><strong>Термін оплати:</strong> до {{ $order->payment_expires_at->timezone(config('app.timezone'))->format('d.m.Y H:i') }}</p>
            <p class="text-muted">Після оплати товар буде підготовлено до відправки.</p>
        </div>
        <div class="col-md-4">
            <h5>Замовлення</h5>
            <ul class="list-group mb-3">
                @php $sum=0; @endphp
                @foreach($order->products as $p)
                    @php $line = $p->pivot->price * $p->pivot->quantity; $sum += $line; @endphp
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="d-flex align-items-center gap-2">
                            @if($p->image_path)
                                <img src="{{ asset('storage/' . $p->image_path) }}" alt="{{ $p->name }}" class="img-thumbnail" style="max-width: 50px; height: auto;">
                            @else
                                <img src="{{ asset('storage/image/121.png') }}" alt="{{ $p->name }}" class="img-thumbnail" style="max-width: 50px; height: auto;">
                            @endif
                            <div>
                                <div class="fw-bold">{{ $p->name }}</div>
                                <div class="text-muted small">x{{ $p->pivot->quantity }}</div>
                            </div>
                        </div>
                        <div>₴ {{ number_format($line, 2, ',', ' ') }}</div>
                    </li>
                @endforeach
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Разом</strong>
                    <strong>₴ {{ number_format($sum, 2, ',', ' ') }}</strong>
                </li>
            </ul>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('shop') }}" class="btn btn-outline-primary">Повернутися до магазину</a>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function(){
    try { localStorage.removeItem('local_cart_v1'); } catch(e){}
})();
</script>
@endpush

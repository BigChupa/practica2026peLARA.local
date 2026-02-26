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
                @if($delivery === 'nova') Нова Пошта @else Укрпошта @endif
                <br>
                {{ $delivery_details ?: '—' }}
            </p>

            <h5>Оплата — банківський переказ</h5>
            <p>Будь ласка, перекажіть суму замовлення на наступні реквізити:</p>
            <ul>
                <li><strong>Отримувач:</strong> {{ $bank['recipient'] }}</li>
                <li><strong>Банк:</strong> {{ $bank['bank'] }}</li>
                <li><strong>IBAN:</strong> {{ $bank['iban'] }}</li>
                <li><strong>MFO:</strong> {{ $bank['mfo'] }}</li>
                <li><strong>Призначення платежу:</strong> {{ $bank['note'] }}</li>
            </ul>

            <p class="text-muted">Після надходження коштів ми підтвердимо замовлення та надішлемо трек-номер.</p>
        </div>
        <div class="col-md-4">
            <h5>Замовлення</h5>
            <ul class="list-group mb-3">
                @php $sum=0; @endphp
                @foreach($order->products as $p)
                    @php $line = $p->pivot->price * $p->pivot->quantity; $sum += $line; @endphp
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div>
                            <div class="fw-bold">{{ $p->name }}</div>
                            <div class="text-muted small">x{{ $p->pivot->quantity }}</div>
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
        <a href="{{ route('shop') }}" class="btn btn-outline-primary">Повернутись до магазину</a>
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

@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Кошик</h1>

    @if($cart->items->isEmpty())
        <div class="alert alert-info">Ваш кошик порожній.</div>
    @else
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Товар</th>
                        <th>Ціна</th>
                        <th>Кількість</th>
                        <th>Разом</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($cart->items as $item)
                        @php $product = $item->product; $line = $product->price * $item->quantity; $total += $line; @endphp
                        <tr>
                            <td>
                                <strong>{{ $product->name }}</strong>
                                <div class="text-muted small">{{ Str::limit($product->description, 80) }}</div>
                            </td>
                            <td>₴ {{ number_format($product->price, 2, ',', ' ') }}</td>
                            <td>
                                <form class="d-flex update-item" method="POST" action="{{ route('cart.update') }}">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="number" name="quantity" min="1" value="{{ $item->quantity }}" class="form-control form-control-sm me-2" style="width:90px">
                                    <button class="btn btn-sm btn-primary">Оновити</button>
                                </form>
                            </td>
                            <td>₴ {{ number_format($line, 2, ',', ' ') }}</td>
                            <td>
                                <form method="POST" action="{{ route('cart.remove') }}">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button class="btn btn-sm btn-danger">Видалити</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end"><strong>Разом:</strong></td>
                        <td colspan="2"><strong>₴ {{ number_format($total, 2, ',', ' ') }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="d-flex justify-content-end">
            <a href="{{ route('shop') }}" class="btn btn-outline-secondary me-2">Повернутися до магазину</a>
            <a id="checkout-btn" href="{{ route('checkout.show') }}" class="btn btn-success">Оформити замовлення</a>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    const IS_AUTH = @json(auth()->check());
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const CART_KEY = 'local_cart_v1';

    function readCart(){ try { return JSON.parse(localStorage.getItem(CART_KEY)) || {}; } catch(e){ return {}; } }

    document.getElementById('checkout-btn')?.addEventListener('click', function(e){
        if(IS_AUTH) return; 
        e.preventDefault();
        const cart = readCart();
        const href = e.currentTarget.href;
        fetch("{{ route('cart.sync') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ cart: cart }),
            keepalive: true
        }).then(function(){
            window.location.href = href;
        }).catch(function(){
            window.location.href = href;
        });
        setTimeout(function(){ window.location.href = href; }, 400);
    });
});
</script>
@endpush

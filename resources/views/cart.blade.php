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
                        <tr data-product-id="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->stock_quantity }}">
                            <td>
                                <div class="d-flex gap-3">
                                    <div style="flex-shrink: 0;">
                                        @if($product->image_path)
                                            <img src="/{{ 'storage/' . $product->image_path }}" alt="{{ $product->name }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px;">
                                        @else
                                            <img src="{{ asset('storage/image/121.png') }}" alt="{{ $product->name }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px;">
                                        @endif
                                    </div>
                                    <div>
                                        <a href="{{ route('shop.product.show', $product) }}" class="text-decoration-none text-dark">
                                            <strong>{{ $product->name }}</strong>
                                        </a>
                                        <div class="text-muted small">{{ Str::limit($product->description, 80) }}</div>
                                        <div class="stock-status text-danger small mt-1" style="display:none;"></div>
                                    </div>
                                </div>
                            </td>
                            <td>₴ {{ number_format($product->price, 2, ',', ' ') }}</td>
                            <td>
                                <form class="d-flex update-item" method="POST" action="{{ route('cart.update') }}">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <div class="input-group" style="width: 120px;">
                                        <button type="button" class="btn btn-outline-secondary btn-sm cart-decrement">−</button>
                                        <input type="number" name="quantity" min="1" value="{{ $item->quantity }}" data-price="{{ $product->price }}" class="form-control form-control-sm cart-quantity-input text-center" style="width: 60px;">
                                        <button type="button" class="btn btn-outline-secondary btn-sm cart-increment">+</button>
                                    </div>
                                </form>
                            </td>
                            <td class="line-total" data-total="{{ $line }}">₴ {{ number_format($line, 2, ',', ' ') }}</td>
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
                        <td colspan="2"><strong id="cart-grand-total">₴ {{ number_format($total, 2, ',', ' ') }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div id="cart-stock-warning" class="alert alert-warning d-none mt-3">
            У кошику є товари, яких немає на складі або кількість перевищує доступний запас. Видаліть їх або зменшіть кількість.
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
    const cartStockWarning = document.getElementById('cart-stock-warning');

    function readCart(){
        try {
            return JSON.parse(localStorage.getItem(CART_KEY)) || {};
        } catch(e) {
            return {};
        }
    }

    function writeCart(cart){
        localStorage.setItem(CART_KEY, JSON.stringify(cart));
    }

    function formatMoney(value){
        return '₴ ' + value.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ' ').replace('.', ',');
    }

    function updateTotals(){
        let total = 0;
        document.querySelectorAll('.line-total').forEach(function(cell){
            total += parseFloat(cell.dataset.total) || 0;
        });
        const totalEl = document.getElementById('cart-grand-total');
        if (totalEl) {
            totalEl.textContent = formatMoney(total);
        }
    }

    function setCartStockWarning(show) {
        if (!cartStockWarning) return;
        cartStockWarning.classList.toggle('d-none', !show);
    }

    function updateCheckoutState() {
        const checkoutBtn = document.getElementById('checkout-btn');
        let blocked = false;

        document.querySelectorAll('tr[data-stock]').forEach(function(row) {
            const stock = parseInt(row.dataset.stock, 10) || 0;
            const input = row.querySelector('.cart-quantity-input');
            const quantity = input ? parseInt(input.value, 10) || 0 : 0;

            if (stock < 1 || quantity > stock) {
                blocked = true;
            }
        });

        if (checkoutBtn) {
            checkoutBtn.disabled = blocked;
            checkoutBtn.classList.toggle('disabled', blocked);
        }

        setCartStockWarning(blocked);
    }

    function updateRowAvailability(row) {
        const stock = parseInt(row.dataset.stock, 10) || 0;
        const quantityInput = row.querySelector('.cart-quantity-input');
        const form = row.querySelector('.update-item');
        const decrement = row.querySelector('.cart-decrement');
        const increment = row.querySelector('.cart-increment');
        const stockStatus = row.querySelector('.stock-status');
        const price = parseFloat(quantityInput?.dataset.price || row.dataset.price) || 0;
        const lineCell = row.querySelector('.line-total');
        const productId = row.querySelector('input[name="product_id"]')?.value;

        if (stock < 1) {
            if (form) form.style.display = 'none';
            if (quantityInput) {
                quantityInput.value = 0;
                quantityInput.disabled = true;
            }
            if (decrement) decrement.disabled = true;
            if (increment) increment.disabled = true;
            if (stockStatus) {
                stockStatus.textContent = 'Немає в наявності';
                stockStatus.style.display = 'block';
            }
            if (lineCell) {
                lineCell.dataset.total = 0;
                lineCell.textContent = formatMoney(0);
            }

            if (!IS_AUTH) {
                const cart = readCart();
                if (productId && cart[productId]) {
                    delete cart[productId];
                    writeCart(cart);
                }
            }
            return;
        }

        if (stockStatus) {
            stockStatus.style.display = 'none';
        }
        if (form) form.style.display = '';
        if (quantityInput) {
            const originalQuantity = parseInt(quantityInput.value, 10) || 1;
            const quantity = Math.max(1, Math.min(stock, originalQuantity));
            quantityInput.value = quantity;
            quantityInput.disabled = false;
            quantityInput.max = stock;
            if (lineCell) {
                const line = quantity * price;
                lineCell.dataset.total = line;
                lineCell.textContent = formatMoney(line);
            }
            if (originalQuantity !== quantity && productId) {
                if (IS_AUTH) {
                    fetch("{{ route('cart.update') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': CSRF_TOKEN,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ product_id: productId, quantity: quantity })
                    }).catch(() => {});
                } else {
                    const cart = readCart();
                    cart[productId] = { quantity: quantity };
                    writeCart(cart);
                }
            }
        }
        if (decrement) decrement.disabled = false;
        if (increment) increment.disabled = false;
    }

    function syncCartDisplayFromLocalStorage(){
        if (IS_AUTH) return;

        const cart = readCart();
        document.querySelectorAll('tr[data-stock]').forEach(function(row){
            const input = row.querySelector('.cart-quantity-input');
            const productId = row.querySelector('input[name="product_id"]')?.value;
            const stock = parseInt(row.dataset.stock, 10) || 0;
            const lineCell = row.querySelector('.line-total');
            const price = parseFloat(input?.dataset.price || row.dataset.price) || 0;

            if (productId && cart[productId] && cart[productId].quantity) {
                let quantity = parseInt(cart[productId].quantity, 10) || 1;
                if (stock < 1) {
                    quantity = 0;
                } else {
                    quantity = Math.max(1, Math.min(stock, quantity));
                }
                if (input) {
                    input.value = quantity;
                }
                const line = quantity * price;
                if (lineCell) {
                    lineCell.dataset.total = line;
                    lineCell.textContent = formatMoney(line);
                }
                if (productId && stock > 0) {
                    cart[productId] = { quantity: quantity };
                }
            }

            updateRowAvailability(row);
        });

        writeCart(cart);
        updateTotals();
        updateCheckoutState();
    }

    function updateRowQuantity(input){
        const form = input.closest('form');
        const productId = form?.querySelector('input[name="product_id"]')?.value;
        const row = input.closest('tr');
        const stock = parseInt(row?.dataset.stock, 10) || 0;
        let quantity = parseInt(input.value, 10) || 1;
        const price = parseFloat(input.dataset.price || row?.dataset.price) || 0;
        const lineCell = row?.querySelector('.line-total');

        if (stock < 1) {
            quantity = 0;
        } else {
            quantity = Math.max(1, Math.min(stock, quantity));
        }

        input.value = quantity;
        if (lineCell) {
            const line = quantity * price;
            lineCell.dataset.total = line;
            lineCell.textContent = formatMoney(line);
        }

        updateTotals();
        updateRowAvailability(row);
        updateCheckoutState();

        if (!productId || stock < 1) {
            return;
        }

        if (IS_AUTH) {
            fetch("{{ route('cart.update') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ product_id: productId, quantity: quantity })
            }).catch(() => {});
        } else {
            const cart = readCart();
            cart[productId] = { quantity: quantity };
            writeCart(cart);
        }
    }

    document.querySelectorAll('.cart-quantity-input').forEach(function(input){
        input.addEventListener('change', function(){
            updateRowQuantity(input);
        });
    });

    document.querySelectorAll('.cart-decrement').forEach(function(button){
        button.addEventListener('click', function(){
            const input = button.closest('form')?.querySelector('.cart-quantity-input');
            const row = button.closest('tr');
            const stock = parseInt(row?.dataset.stock, 10) || 0;
            if (!input || stock < 1) return;
            const currentValue = parseInt(input.value, 10) || 1;
            input.value = Math.max(1, currentValue - 1);
            updateRowQuantity(input);
        });
    });

    document.querySelectorAll('.cart-increment').forEach(function(button){
        button.addEventListener('click', function(){
            const input = button.closest('form')?.querySelector('.cart-quantity-input');
            const row = button.closest('tr');
            const stock = parseInt(row?.dataset.stock, 10) || 0;
            if (!input || stock < 1) return;
            const currentValue = parseInt(input.value, 10) || 1;
            input.value = Math.min(stock, currentValue + 1);
            updateRowQuantity(input);
        });
    });

    document.querySelectorAll('.update-item').forEach(function(form){
        form.addEventListener('submit', function(e){
            e.preventDefault();
        });
    });

    document.querySelectorAll('form[action="{{ route('cart.remove') }}"]').forEach(function(form){
        form.addEventListener('submit', function(){
            if (IS_AUTH) return;

            const productId = form.querySelector('input[name="product_id"]').value;
            const cart = readCart();
            delete cart[productId];
            writeCart(cart);
        });
    });

    if (!IS_AUTH) {
        syncCartDisplayFromLocalStorage();
    } else {
        document.querySelectorAll('tr[data-stock]').forEach(updateRowAvailability);
        updateCheckoutState();
    }

    document.getElementById('checkout-btn')?.addEventListener('click', function(e){
        if (e.currentTarget.disabled) {
            e.preventDefault();
            return;
        }
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

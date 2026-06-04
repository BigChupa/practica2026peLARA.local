@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>{{ $product->name }}</h1>
            <p class="text-muted mb-0">SKU: {{ $product->sku }}</p>
            <p class="text-muted">Категорія: {{ $product->category->name ?? 'Без категорії' }}</p>
        </div>
        <div class="col-md-4 text-end align-self-center">
            <a href="{{ route('shop') }}" class="btn btn-outline-secondary">Повернутися до магазину</a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card shadow-sm">
                @if($product->image_path)
                    <img src="/storage/{{ str_replace('app/public/', '', $product->image_path) }}" class="card-img-top" alt="{{ $product->name }}">
                @else
                    <img src="/storage/image/121.png" class="card-img-top" alt="{{ $product->name }}">
                @endif
                <div class="card-body">
                    <p class="h4 text-danger">₴ {{ number_format($product->price, 2, ',', ' ') }}</p>
                    <p class="mb-0"><strong>Наявність:</strong> {{ $product->stock_quantity }} шт.</p>
                    <p class="mb-0"><strong>Сумісність:</strong> {{ $product->compatible_make ? $product->compatible_make . ' ' . $product->compatible_model . ' ' . $product->compatible_year : 'Не вказано' }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Опис товару</h5>
                    <p class="card-text">{{ $product->description ?: 'Опис відсутній.' }}</p>

                    <ul class="list-group list-group-flush mb-3">
                        <li class="list-group-item"><strong>Категорія:</strong> {{ $product->category->name ?? 'Без категорії' }}</li>
                        <li class="list-group-item"><strong>Автомобіль:</strong> {{ $product->car ? $product->car->make . ' ' . $product->car->model . ' (' . $product->car->year . ')' : 'Не вказано' }}</li>
                    </ul>

                    <form method="POST" action="{{ route('cart.add') }}" class="mt-4" id="product-cart-form">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="row g-2 align-items-center mb-3">
                            <div class="col-auto">
                                <label for="quantity-input" class="form-label mb-0">Кількість</label>
                            </div>
                            <div class="col-auto">
                                <div class="input-group" style="width: 140px;">
                                    <button type="button" class="btn btn-outline-secondary btn-sm decrement">−</button>
                                    <input type="number" name="quantity" id="quantity-input" class="form-control form-control-sm text-center" value="{{ max(0, $cartQuantity) }}" min="0" max="{{ $product->stock_quantity }}">
                                    <button type="button" class="btn btn-outline-secondary btn-sm increment">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-danger btn-lg" id="product-remove-from-cart">Видалити з кошика</button>
                        </div>
                        <div class="mt-3">
                            <div id="product-cart-status" class="text-success" style="display:none;"></div>
                            <div id="product-out-of-stock" class="text-danger" style="display:none;">Товар відсутній на складі.</div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const IS_AUTH = @json(auth()->check());
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const CART_KEY = 'local_cart_v1';

    const quantityInput = document.getElementById('quantity-input');
    const decrementButton = document.querySelector('.decrement');
    const incrementButton = document.querySelector('.increment');
    const addToCartForm = document.getElementById('product-cart-form');
    const removeFromCartButton = document.getElementById('product-remove-from-cart');
    const statusElement = document.getElementById('product-cart-status');
    const outOfStockElement = document.getElementById('product-out-of-stock');
    const productId = '{{ $product->id }}';
    const STOCK_QUANTITY = @json($product->stock_quantity);

    function readCart() {
        try {
            return JSON.parse(localStorage.getItem(CART_KEY)) || {};
        } catch (e) {
            return {};
        }
    }

    function writeCart(cart) {
        localStorage.setItem(CART_KEY, JSON.stringify(cart));
    }

    function updateLocalCart(quantity) {
        const cart = readCart();
        if (quantity > 0) {
            cart[productId] = { quantity: quantity };
        } else {
            delete cart[productId];
        }
        writeCart(cart);
    }

    function showStatus(message, isError = false) {
        if (!statusElement) return;
        statusElement.textContent = message;
        statusElement.classList.toggle('text-danger', isError);
        statusElement.classList.toggle('text-success', !isError);
        statusElement.style.display = 'block';
        clearTimeout(statusElement._timeout);
        statusElement._timeout = setTimeout(function() {
            statusElement.style.display = 'none';
        }, 3000);
    }

    if (!quantityInput) {
        return;
    }

    function updateProductStockState() {
        if (STOCK_QUANTITY < 1) {
            quantityInput.disabled = true;
            decrementButton.disabled = true;
            incrementButton.disabled = true;
            if (removeFromCartButton) {
                removeFromCartButton.disabled = false;
            }
            if (outOfStockElement) {
                outOfStockElement.style.display = 'block';
            }
            showStatus('Товар відсутній на складі.', true);
        } else {
            if (outOfStockElement) {
                outOfStockElement.style.display = 'none';
            }
        }
    }

    updateProductStockState();

    const maxQuantity = parseInt(quantityInput.max, 10) || 9999;
    let changeTimeout;

    function saveQuantity(quantity) {
        if (STOCK_QUANTITY < 1) {
            quantityInput.value = 0;
            showStatus('Товар відсутній на складі.', true);
            return;
        }

        if (quantity > maxQuantity) {
            quantity = maxQuantity;
            showStatus('Немає в наявності стільки одиниць. Максимум ' + maxQuantity + '.', true);
        }

        quantity = Math.max(0, quantity);
        quantityInput.value = quantity;

        if (IS_AUTH) {
            fetch("{{ route('cart.add') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ product_id: productId, quantity: quantity })
            }).then(function(response) {
                if (!response.ok) {
                    throw new Error('Помилка збереження');
                }
                return response.json();
            }).then(function() {
                if (quantity === 0) {
                    showStatus('Товар видалено з кошика.');
                } else {
                    showStatus('Кількість збережено у кошику.');
                }
            }).catch(function() {
                showStatus('Не вдалося зберегти кількість.', true);
            });
        } else {
            updateLocalCart(quantity);
            showStatus('Кількість збережено у кошику.');
        }
    }

    decrementButton?.addEventListener('click', function() {
        const currentValue = parseInt(quantityInput.value, 10) || 0;
        saveQuantity(currentValue - 1);
    });

    incrementButton?.addEventListener('click', function() {
        const currentValue = parseInt(quantityInput.value, 10) || 0;
        saveQuantity(currentValue + 1);
    });

    quantityInput.addEventListener('input', function() {
        clearTimeout(changeTimeout);
        changeTimeout = setTimeout(function() {
            saveQuantity(parseInt(quantityInput.value, 10) || 0);
        }, 400);
    });

    addToCartForm?.addEventListener('submit', function(e) {
        e.preventDefault();
    });

    removeFromCartButton?.addEventListener('click', function() {
        if (!CSRF_TOKEN) return;

        fetch("{{ route('cart.remove') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ product_id: productId })
        }).then(function(response) {
            if (!response.ok) {
                throw new Error('Помилка видалення');
            }
            return response.json();
        }).then(function() {
            if (!IS_AUTH) {
                updateLocalCart(0);
            }
            quantityInput.value = 0;
            showStatus('Товар видалено з кошика.');
        }).catch(function() {
            showStatus('Не вдалося видалити товар з кошика.', true);
        });
    });
});
</script>
@endpush
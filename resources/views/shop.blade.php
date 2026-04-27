          
@extends('layouts.app')

@section('content')
<div class="hero">
    <div class="container">
        <h1>Магазин запчастин</h1>
        <p>Якісні запчастини для вашого автомобіля</p>
            <div class="float-end">
                <a id="top-cart-link" href="{{ route('cart.index') }}" class="btn btn-success">Перейти до кошика</a>
            </div>
    </div>
</div>

<div class="container py-5">
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <section class="mb-5">
        <div class="row mb-4">
            <div class="col-md-4">
                <form method="GET" action="{{ route('shop') }}">
                    <div class="mb-3">
                        <label class="form-label">Пошук</label>
                        <input type="search" name="q" class="form-control" value="{{ request('q') }}" placeholder="Пошук товарів...">
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-car"></i> Вибір автомобіля</label>
                        <select name="car_make" id="car-make" class="form-select">
                            <option value="">-- Виберіть марку --</option>
                            @foreach($makes as $make)
                                <option value="{{ $make }}" {{ request('car_make') == $make ? 'selected' : '' }}>{{ $make }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3" id="model-select-wrapper" style="display: none;">
                        <label class="form-label">Модель</label>
                        <select name="car_model" id="car-model" class="form-select">
                            <option value="">-- Виберіть модель --</option>
                        </select>
                    </div>

                    <div class="mb-3" id="year-select-wrapper" style="display: none;">
                        <label class="form-label">Рік</label>
                        <select name="car_year" id="car-year" class="form-select">
                            <option value="">-- Виберіть рік --</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Категорія</label>
                        <select name="category_id" class="form-select">
                            <option value="">Всі категорії</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">Ціна від</label>
                            <input type="number" name="price_min" class="form-control" value="{{ request('price_min') }}" min="0">
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Ціна до</label>
                            <input type="number" name="price_max" class="form-control" value="{{ request('price_max') }}" min="0">
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn btn-primary">Фільтрувати</button>
                        <a href="{{ route('shop') }}" class="btn btn-outline-secondary">Скинути</a>
                    </div>
                </form>
            </div>

            <div class="col-md-8">
                <h2 class="mb-3">Товари</h2>
                <div class="row">
                    @forelse($products as $product)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                @if($product->image_path)
                                    <img src="{{ asset('storage/' . $product->image_path) }}" class="card-img-top" alt="{{ $product->name }}">
                                @else
                                    <img src="{{ asset('storage/image/121.png') }}" class="card-img-top" alt="{{ $product->name }}">
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                                    <p class="text-danger"><strong>₴ {{ number_format($product->price, 2, ',', ' ') }}</strong></p>
                                </div>
                                <div class="card-footer bg-white">
                                    <div class="cart-controls" data-product-id="{{ $product->id }}">
                                        <button class="btn btn-outline-primary btn-sm add-to-cart w-100">Додати до кошика</button>
                                        <a href="{{ route('cart.index') }}" class="btn btn-success btn-sm go-to-cart w-100 mt-2 d-none">Перейти до кошика</a>
                                        <div class="d-none qty-controls mt-2">
                                            <div class="input-group">
                                                <button class="btn btn-sm btn-outline-secondary decrement" type="button">−</button>
                                                <input type="text" class="form-control form-control-sm text-center qty" value="1" readonly>
                                                <button class="btn btn-sm btn-outline-secondary increment" type="button">+</button>
                                            </div>
                                            <button class="btn btn-danger btn-sm mt-2 remove-item w-100">Видалити</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info">Товари не знайдені.</div>
                        </div>
                    @endforelse
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $products->links('vendor.pagination.simple-custom') }}
                </div>
            </div>
        </div>
    </section>

    <hr class="my-5">

    <section class="mb-5">
        <div class="row">
            <div class="col-md-4 text-center mb-4">
                <h5>✓ Оригінальні товари</h5>
                <p>Тільки сертифіковані запчастини від перевірених виробників</p>
            </div>
            <div class="col-md-4 text-center mb-4">
                <h5>✓ Швидка доставка</h5>
                <p>Доставка по Львову за 24 години</p>
            </div>
            <div class="col-md-4 text-center mb-4">
                <h5>✓ Гарантія</h5>
                <p>Гарантія на всі товари від 1 року</p>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    const CART_KEY = 'local_cart_v1';
    const IS_AUTH = @json(auth()->check());
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    function readCart(){
        try { return JSON.parse(localStorage.getItem(CART_KEY)) || {}; } catch(e) { return {}; }
    }
    function writeCart(cart){ localStorage.setItem(CART_KEY, JSON.stringify(cart)); }

    function updateControls(container, productId){
        const cart = readCart();
        const item = cart[productId];
        const addBtn = container.querySelector('.add-to-cart');
        const goBtn = container.querySelector('.go-to-cart');
        const qtyBox = container.querySelector('.qty-controls');
        const qtyInput = container.querySelector('.qty');
        if(item){
            addBtn.classList.add('d-none');
            if(goBtn) goBtn.classList.remove('d-none');
            qtyBox.classList.remove('d-none');
            qtyInput.value = item.quantity;
        } else {
            addBtn.classList.remove('d-none');
            if(goBtn) goBtn.classList.add('d-none');
            qtyBox.classList.add('d-none');
        }
    }

    document.querySelectorAll('.cart-controls').forEach(function(container){
        const productId = container.getAttribute('data-product-id');
        updateControls(container, productId);

        container.querySelector('.add-to-cart')?.addEventListener('click', function(){
            const cart = readCart();
            cart[productId] = { quantity: 1 };
            writeCart(cart);
            if(IS_AUTH){
                fetch("{{ route('cart.add') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ product_id: productId, quantity: 1 })
                }).catch(()=>{});
            }
            updateControls(container, productId);
        });

        container.querySelector('.increment')?.addEventListener('click', function(){
            const cart = readCart();
            if(!cart[productId]) cart[productId] = { quantity: 0 };
            cart[productId].quantity = (cart[productId].quantity || 0) + 1;
            writeCart(cart);
            if(IS_AUTH){
                fetch("{{ route('cart.add') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ product_id: productId, quantity: cart[productId].quantity })
                }).catch(()=>{});
            }
            updateControls(container, productId);
        });

        container.querySelector('.decrement')?.addEventListener('click', function(){
            const cart = readCart();
            if(!cart[productId]) return;
            cart[productId].quantity = Math.max(1, (cart[productId].quantity || 1) - 1);
            writeCart(cart);
            if(IS_AUTH){
                fetch("{{ route('cart.update') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ product_id: productId, quantity: cart[productId].quantity })
                }).catch(()=>{});
            }
            updateControls(container, productId);
        });

        container.querySelector('.remove-item')?.addEventListener('click', function(){
            const cart = readCart();
            delete cart[productId];
            writeCart(cart);
            if(IS_AUTH){
                fetch("{{ route('cart.remove') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ product_id: productId })
                }).catch(()=>{});
            }
            updateControls(container, productId);
        });

        container.querySelector('.go-to-cart')?.addEventListener('click', function(e){
            if(IS_AUTH) return; 
            e.preventDefault();
            const cart = readCart();
            const href = container.querySelector('.go-to-cart').href;
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

    document.getElementById('top-cart-link')?.addEventListener('click', function(e){
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

    // Фільтр по марке/модели/году (Cascading selects)
    const carMakeSelect = document.getElementById('car-make');
    const carModelSelect = document.getElementById('car-model');
    const carYearSelect = document.getElementById('car-year');
    const modelSelectWrapper = document.getElementById('model-select-wrapper');
    const yearSelectWrapper = document.getElementById('year-select-wrapper');

    // Инициализация при загрузке страницы
    if (carMakeSelect && carMakeSelect.value) {
        loadModels(carMakeSelect.value);
    }
    if (carModelSelect && carModelSelect.value && carMakeSelect && carMakeSelect.value) {
        loadYears(carMakeSelect.value, carModelSelect.value);
    }

    // Обработчик изменения марки
    carMakeSelect?.addEventListener('change', function() {
        if (!this.value) {
            carModelSelect.innerHTML = '<option value="">-- Виберіть модель --</option>';
            carYearSelect.innerHTML = '<option value="">-- Виберіть рік --</option>';
            modelSelectWrapper.style.display = 'none';
            yearSelectWrapper.style.display = 'none';
            return;
        }

        loadModels(this.value);
    });

    // Обработчик изменения модели
    carModelSelect?.addEventListener('change', function() {
        if (!this.value || !carMakeSelect.value) {
            carYearSelect.innerHTML = '<option value="">-- Виберіть рік --</option>';
            yearSelectWrapper.style.display = 'none';
            return;
        }

        loadYears(carMakeSelect.value, this.value);
    });

    function loadModels(make) {
        fetch("{{ route('shop.models') }}?make=" + encodeURIComponent(make))
            .then(r => r.json())
            .then(data => {
                carModelSelect.innerHTML = '<option value="">-- Виберіть модель --</option>';
                data.models.forEach(model => {
                    const option = document.createElement('option');
                    option.value = model;
                    option.textContent = model;
                    if (model === "{{ request('car_model') }}") {
                        option.selected = true;
                    }
                    carModelSelect.appendChild(option);
                });
                modelSelectWrapper.style.display = 'block';
                
                // Якщо була вибрана модель, завантажити роки
                if (carModelSelect.value) {
                    loadYears(make, carModelSelect.value);
                }
            })
            .catch(e => console.error('Помилка завантаження моделей:', e));
    }

    function loadYears(make, model) {
        fetch("{{ route('shop.years') }}?make=" + encodeURIComponent(make) + "&model=" + encodeURIComponent(model))
            .then(r => r.json())
            .then(data => {
                carYearSelect.innerHTML = '<option value="">-- Виберіть рік --</option>';
                data.years.forEach(year => {
                    const option = document.createElement('option');
                    option.value = year;
                    option.textContent = year;
                    if (year === "{{ request('car_year') }}") {
                        option.selected = true;
                    }
                    carYearSelect.appendChild(option);
                });
                yearSelectWrapper.style.display = 'block';
            })
            .catch(e => console.error('Помилка завантаження років:', e));
    }
});
</script>
@endpush

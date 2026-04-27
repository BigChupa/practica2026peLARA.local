@extends('layouts.app')

@section('content')
    <div class="container py-5">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row mb-4">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold">Сервіси</h1>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0">
                        <li class="breadcrumb-item"><a href="{{ route('services') }}">Послуги</a></li>
                        @if($selectedCategory)
                            <li class="breadcrumb-item"><a href="{{ route('services', ['category' => $selectedCategory['slug']]) }}">{{ $selectedCategory['title'] }}</a></li>
                        @endif
                        @if($selectedService)
                            <li class="breadcrumb-item active" aria-current="page">{{ $selectedService['name'] }}</li>
                        @endif
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row gx-4 gy-4">
            <div class="col-lg-8">
                @if($selectedService)
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h2 class="fw-bold">{{ $selectedService['name'] }}</h2>
                            <p class="text-muted mb-2">Категорія: {{ $selectedCategory['title'] }}</p>
                            <div class="mb-3">
                                <strong>Ціна:</strong> ₴{{ number_format($selectedService['price'], 2, ',', ' ') }}
                            </div>
                            <p>{{ $selectedService['description'] }}</p>
                        </div>
                    </div>
                @elseif($selectedCategory)
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h2 class="fw-bold">{{ $selectedCategory['title'] }}</h2>
                            <p class="text-muted">{{ $selectedCategory['description'] }}</p>
                        </div>
                    </div>

                    <div class="row row-cols-1 row-cols-md-2 g-4">
                        @foreach($selectedCategory['services'] as $service)
                            <div class="col">
                                <div class="card h-100 shadow-sm">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">{{ $service['name'] }}</h5>
                                        <p class="text-muted mb-3">{{ $service['description'] }}</p>
                                        <div class="mt-auto">
                                            <p class="fw-bold mb-3">₴{{ number_format($service['price'], 2, ',', ' ') }}</p>
                                            <a href="{{ route('services', ['service' => $service['slug']]) }}" class="btn btn-outline-primary btn-sm">Деталі послуги</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h2 class="fw-bold">Запис на СТО</h2>
                            <p class="text-muted">Заповніть форму, і ми зв'яжемося з вами для узгодження послуги, часу і вартості.</p>
                            <div class="mt-3">
                                <p class="mb-1"><strong>Переваги запису:</strong></p>
                                <ul class="ps-3 mb-0">
                                    <li>Перший вільний час під ваш автомобіль</li>
                                    <li>Індивідуальна консультація</li>
                                    <li>Розрахунок вартості за дзвінком</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Запис на послугу</h4>
                    </div>
                    <div class="card-body">
                        @if($selectedService)
                            <form action="{{ route('appointments.store') }}" method="POST">
                                @csrf

                                <input type="hidden" name="service_id" value="{{ $selectedService['id'] ?? '' }}">
                                <input type="hidden" name="service_name" value="{{ $selectedService['name'] }}">

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Послуга</label>
                                    <div class="form-control-plaintext border rounded px-3 py-2 bg-light">
                                        {{ $selectedService['name'] }}
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="name" class="form-label fw-bold">Ім'я</label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Ваше ім'я" required>
                                    @error('name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="phoneVisible" class="form-label fw-bold">Телефон</label>
                                    <div class="input-group">
                                        <span class="input-group-text">+380</span>
                                        <input type="text" id="phoneVisible" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') ? preg_replace('/^\+380\s*/', '', old('phone')) : '' }}" placeholder="(66) 111-11-11" inputmode="tel" required>
                                    </div>
                                    <input type="hidden" name="phone" id="phone" value="{{ old('phone') }}">
                                    @error('phone')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="notes" class="form-label fw-bold">Коментар</label>
                                    <textarea name="notes" id="notes" rows="4" class="form-control @error('notes') is-invalid @enderror" placeholder="Напишіть про проблему або додаткові побажання...">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-success w-100">Надіслати запит</button>
                            </form>
                        @else
                            <form action="{{ route('appointments.store') }}" method="POST">
                                @csrf

                                <input type="hidden" name="service_name" value="Запис на СТО"> 

                                <div class="mb-3">
                                    <label for="name" class="form-label fw-bold">Ім'я</label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Ваше ім'я" required>
                                    @error('name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="phoneVisible" class="form-label fw-bold">Телефон</label>
                                    <div class="input-group">
                                        <span class="input-group-text">+380</span>
                                        <input type="text" id="phoneVisible" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') ? preg_replace('/^\+380\s*/', '', old('phone')) : '' }}" placeholder="(66) 111-11-11" inputmode="tel" required>
                                    </div>
                                    <input type="hidden" name="phone" id="phone" value="{{ old('phone') }}">
                                    @error('phone')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="notes" class="form-label fw-bold">Коментар</label>
                                    <textarea name="notes" id="notes" rows="4" class="form-control @error('notes') is-invalid @enderror" placeholder="Напишіть про проблему або додаткові побажання...">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-success w-100">Надіслати запит</button>
                            </form>
                        @endif
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Графік роботи</h5>
                        <p class="mb-1"><strong>Пн-Пт:</strong> 08:00 - 18:00</p>
                        <p class="mb-1"><strong>Сб:</strong> 09:00 - 14:00</p>
                        <p class="mb-3"><strong>Нд:</strong> вихідний</p>

                        <h5 class="card-title mt-4">Контактний телефон</h5>
                        <p class="mb-3"><a href="tel:+380123456789" class="link-dark">+380 12 345 67 89</a></p>

                        <h5 class="card-title mt-4">Адреса</h5>
                        <p class="mb-0">вул. Центральна, 25, Київ</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var phoneVisible = document.getElementById('phoneVisible');
            var phoneHidden = document.getElementById('phone');

            if (!phoneVisible || !phoneHidden) {
                return;
            }

            function formatPhoneValue(value) {
                var digits = value.replace(/\D/g, '').slice(0, 9);
                var formatted = '';

                if (digits.length > 0) {
                    formatted += '(' + digits.slice(0, 2);
                }
                if (digits.length >= 3) {
                    formatted += ') ' + digits.slice(2, 5);
                }
                if (digits.length >= 6) {
                    formatted += '-' + digits.slice(5, 7);
                }
                if (digits.length >= 8) {
                    formatted += '-' + digits.slice(7, 9);
                }

                return formatted;
            }

            function syncPhone() {
                var formatted = formatPhoneValue(phoneVisible.value);
                phoneVisible.value = formatted;
                phoneHidden.value = formatted ? '+380 ' + formatted : '';
            }

            phoneVisible.addEventListener('input', function () {
                var cursor = phoneVisible.selectionStart;
                var before = phoneVisible.value;
                syncPhone();
                var after = phoneVisible.value;
                if (after.length > before.length) {
                    phoneVisible.setSelectionRange(cursor, cursor);
                }
            });

            phoneVisible.addEventListener('blur', syncPhone);
            syncPhone();
        });
    </script>
@endpush
@endsection

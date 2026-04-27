@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Запис на послугу: <strong>{{ $service->name }}</strong></h3>
                    </div>

                    <div class="card-body">
                        <div class="alert alert-info">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Опис:</strong><br>
                                    {{ $service->description ?? 'Немає опису' }}
                                </div>
                                <div class="col-md-3">
                                    <strong>Вартість:</strong><br>
                                    <span class="badge bg-success fs-6">₴{{ number_format($service->price, 2, ',', ' ') }}</span>
                                </div>
                                <div class="col-md-3">
                                    <strong>Тривалість:</strong><br>
                                    {{ $service->duration_minutes }} хвилин
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-8">
                                <h6 class="text-muted">Розпорядок роботи:</h6>
                                <p>
                                    <strong>Понеділок - Пʼятниця:</strong> 08:00 - 18:00<br>
                                    <strong>Субота:</strong> 09:00 - 14:00<br>
                                    <strong>Неділя:</strong> Вихідний
                                </p>
                            </div>
                        </div>

                        <hr>

                        <h6 class="fw-bold mb-3">Заповніть форму для запису</h6>

                        <form action="{{ route('appointments.store') }}" method="POST">
                            @csrf

                            <input type="hidden" name="service_id" value="{{ $service->id }}">

                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">
                                    Ім'я клієнта <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control @error('name') is-invalid @enderror"
                                    id="name"
                                    name="name"
                                    placeholder="Ваше ім'я"
                                    value="{{ old('name') }}"
                                    required
                                >
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="phoneVisible" class="form-label fw-bold">
                                    Номер телефону <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">+380</span>
                                    <input 
                                        type="text" 
                                        class="form-control @error('phone') is-invalid @enderror"
                                        id="phoneVisible"
                                        value="{{ old('phone') ? preg_replace('/^\+380\s*/', '', old('phone')) : '' }}"
                                        placeholder="(66) 111-11-11"
                                        inputmode="tel"
                                        required
                                    >
                                </div>
                                <input type="hidden" name="phone" id="phone" value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="notes" class="form-label fw-bold">
                                    Примітка (опціонально)
                                </label>
                                <textarea 
                                    class="form-control @error('notes') is-invalid @enderror"
                                    id="notes"
                                    name="notes"
                                    rows="4"
                                    placeholder="Розповідьте про проблему або запитання...">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary btn-lg flex-grow-1">
                                    <i class="bi bi-check-circle"></i> Надіслати запит
                                </button>
                                <a href="{{ route('services') }}" class="btn btn-secondary btn-lg">
                                    Скасувати
                                </a>
                            </div>
                        </form>
                    </div>

                    <div class="card-footer text-muted small">
                        <i class="bi bi-info-circle"></i> Ми розглянемо ваш запит та зв'яжемося з вами протягом 24 годин.
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

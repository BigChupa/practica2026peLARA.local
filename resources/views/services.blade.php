@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Запис на послугу</h3>
                    </div>

                    <div class="card-body">
                        
                        
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
                            <input type="hidden" name="service_id" value="1">

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
                                <label for="phone" class="form-label fw-bold">
                                    Номер телефону <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="tel" 
                                    class="form-control @error('phone') is-invalid @enderror"
                                    id="phone"
                                    name="phone"
                                    placeholder="+380 (XX) XXX-XX-XX"
                                    value="{{ old('phone') }}"
                                    required
                                >
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
@endsection

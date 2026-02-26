@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <a href="{{ route('appointments.index') }}" class="btn btn-secondary mb-3">
                    ← Назад до списку
                </a>

                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Деталі запиту на послугу</h3>
                    </div>

                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5>Послуга</h5>
                                <p class="fs-5 fw-bold text-primary">{{ $appointment->service->name }}</p>
                                @if($appointment->service->description)
                                    <p class="text-muted">{{ $appointment->service->description }}</p>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <h5>Статус запиту</h5>
                                <div class="mb-2">
                                    @switch($appointment->status)
                                        @case('pending')
                                            <span class="badge bg-warning p-2">Очікує на розгляд</span>
                                            @break
                                        @case('confirmed')
                                            <span class="badge bg-success p-2">Підтверджено</span>
                                            @break
                                        @case('completed')
                                            <span class="badge bg-info p-2">Завершено</span>
                                            @break
                                        @case('cancelled')
                                            <span class="badge bg-danger p-2">Скасовано</span>
                                            @break
                                    @endswitch
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6 class="text-muted">Ім'я клієнта</h6>
                                <p class="fs-5">{{ $appointment->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted">Номер телефону</h6>
                                <p class="fs-5">
                                    <a href="tel:{{ $appointment->phone }}">{{ $appointment->phone }}</a>
                                </p>
                            </div>
                        </div>

                        <hr>

                        @if($appointment->notes)
                            <div class="mb-4">
                                <h6 class="text-muted">Примітка</h6>
                                <p class="fs-5">{{ $appointment->notes }}</p>
                            </div>
                            <hr>
                        @endif

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6 class="text-muted">Вартість послуги</h6>
                                <p class="fs-5 text-success">
                                    <strong>₴{{ number_format($appointment->service->price, 2, ',', ' ') }}</strong>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted">Тривалість</h6>
                                <p class="fs-5">
                                    {{ $appointment->service->duration_minutes }} хвилин
                                </p>
                            </div>
                        </div>

                        <hr>

                        <div class="text-muted small">
                            <p>
                                Запит створено: {{ $appointment->created_at->format('d.m.Y H:i') }}
                            </p>
                        </div>
                    </div>

                    <div class="card-footer bg-light">
                        <a href="{{ route('appointments.index') }}" class="btn btn-secondary">
                            Назад до списку
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

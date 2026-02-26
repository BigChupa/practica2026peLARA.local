@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1>Запити на послуги</h1>
                    <a href="{{ route('services') }}" class="btn btn-primary">
                        Новий запит
                    </a>
                </div>

                @if($appointments->isEmpty())
                    <div class="alert alert-info">
                        <p>Наразі немає запитів на послуги.</p>
                        <a href="{{ route('services') }}" class="alert-link">Перейти до запису</a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Послуга</th>
                                    <th>Ім'я клієнта</th>
                                    <th>Номер</th>
                                    <th>Статус</th>
                                    <th>Дата запиту</th>
                                    <th>Дій</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($appointments as $appointment)
                                    <tr>
                                        <td>
                                            <strong>{{ $appointment->service->name }}</strong>
                                        </td>
                                        <td>
                                            {{ $appointment->name }}
                                        </td>
                                        <td>
                                            <a href="tel:{{ $appointment->phone }}">{{ $appointment->phone }}</a>
                                        </td>
                                        <td>
                                            @switch($appointment->status)
                                                @case('pending')
                                                    <span class="badge bg-warning">Очікує</span>
                                                    @break
                                                @case('confirmed')
                                                    <span class="badge bg-success">Підтверджено</span>
                                                    @break
                                                @case('completed')
                                                    <span class="badge bg-info">Завершено</span>
                                                    @break
                                                @case('cancelled')
                                                    <span class="badge bg-danger">Скасовано</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>
                                            {{ $appointment->created_at->format('d.m.Y H:i') }}
                                        </td>
                                        <td>
                                            <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-sm btn-info">
                                                Деталі
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

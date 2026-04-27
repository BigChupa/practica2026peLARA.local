@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-users"></i> Записані на СТО</h2>
        </div>
            <div class="col-md-4 text-end">
                <a href="https://practica2026pelara.local/public/admin" class="btn btn-outline-secondary">В адмін-панель</a>
            </div>
    </div>
  <div class="row">
    <div class="col-md-6">
      <div class="card border-primary mb-4">
        <div class="card-header bg-primary text-white">Кому ще треба подзвонити</div>
        <div class="card-body">
          @if($toCall->count())
            <ul class="list-group">
              @foreach($toCall as $appointment)
                <li class="list-group-item">
                  <strong>{{ $appointment->name }}</strong> — {{ $appointment->phone }}<br>
                  <span class="text-muted">{{ $appointment->appointment_date ?? 'Дата не вказана' }}</span><br>
                  <span class="text-secondary">Послуга: {{ $appointment->service_name ?? '-' }}</span>
                  @if($appointment->notes)
                    <div><small>Примітки: {{ $appointment->notes }}</small></div>
                  @endif
                  <form action="{{ route('admin.sto.appointments.verify', $appointment->id) }}" method="POST" style="display:inline-block; margin-top: 8px;">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-success">Перевірено</button>
                  </form>
                </li>
              @endforeach
            </ul>
          @else
            <div class="text-muted">Немає записів</div>
          @endif
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card border-success mb-4">
        <div class="card-header bg-success text-white">Кому вже подзвонили</div>
        <div class="card-body">
          @if($called->count())
            <ul class="list-group">
              @foreach($called as $appointment)
                <li class="list-group-item">
                  <strong>{{ $appointment->name }}</strong> — {{ $appointment->phone }}<br>
                  <span class="text-muted">{{ $appointment->appointment_date ?? 'Дата не вказана' }}</span><br>
                  <span class="text-secondary">Послуга: {{ $appointment->service_name ?? '-' }}</span>
                  @if($appointment->notes)
                    <div><small>Примітки: {{ $appointment->notes }}</small></div>
                  @endif
                </li>
              @endforeach
            </ul>
          @else
            <div class="text-muted">Немає записів</div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <div class="row align-items-center mb-4">
    <div class="col-md-8">
      <h2 class="mb-0"><i class="fas fa-users"></i> Записані на СТО</h2>
      <p class="text-muted mb-0">Тут показані нові заявки та ті, кому вже подзвонили.</p>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
      <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">В адмін-панель</a>
    </div>
  </div>

  <div class="card mb-4">
    <div class="card-body">
      <form method="GET" action="{{ route('admin.sto.appointments') }}" class="row g-2 align-items-center">
        <div class="col-md-4">
          <select name="search_type" class="form-select">
            <option value="" {{ (old('search_type', $searchType ?? '') === '') ? 'selected' : '' }}>Всі критерії</option>
            <option value="name" {{ (old('search_type', $searchType ?? '') === 'name') ? 'selected' : '' }}>Ім'я</option>
            <option value="phone" {{ (old('search_type', $searchType ?? '') === 'phone') ? 'selected' : '' }}>Телефон</option>
            <option value="service_name" {{ (old('search_type', $searchType ?? '') === 'service_name') ? 'selected' : '' }}>Послуга</option>
            <option value="notes" {{ (old('search_type', $searchType ?? '') === 'notes') ? 'selected' : '' }}>Коментар</option>
          </select>
        </div>
        <div class="col-md-5">
          <input type="text" name="search" class="form-control" placeholder="Введіть пошуковий запит" value="{{ old('search', $search ?? '') }}">
        </div>
        <div class="col-md-3 d-flex gap-2">
          <button type="submit" class="btn btn-primary flex-grow-1">Знайти</button>
          <a href="{{ route('admin.sto.appointments') }}" class="btn btn-outline-primary flex-grow-1">Скинути</a>
        </div>
      </form>
    </div>
  </div>

  <div class="row g-4">
    <div class="col-md-6">
      <div class="card border-primary shadow-sm h-100">
        <div class="card-header bg-primary text-white">Кому ще треба подзвонити</div>
        <div class="card-body">
          @forelse($toCall as $appointment)
            <div class="mb-3 pb-3 border-bottom">
              <div class="d-flex justify-content-between align-items-start">
                <div>
                  <h5 class="mb-1">{{ $appointment->name }}</h5>
                  <p class="mb-1 text-muted">{{ $appointment->phone }}</p>
                  <p class="mb-1 text-secondary">Послуга: {{ $appointment->service_name ?? '-' }}</p>
                  <p class="small text-muted mb-0">{{ $appointment->appointment_date ? \Illuminate\Support\Carbon::parse($appointment->appointment_date)->format('d.m.Y H:i') : ($appointment->created_at ? $appointment->created_at->format('d.m.Y H:i') : 'Дата не вказана') }}</p>
                </div>
                <form action="{{ route('admin.sto.appointments.verify', $appointment->id) }}" method="POST" class="ms-3">
                  @csrf
                  <button type="submit" class="btn btn-sm btn-success">Перевірено</button>
                </form>
              </div>
              @if($appointment->notes)
                <p class="mt-2 mb-0"><small class="text-muted">Примітки: {{ $appointment->notes }}</small></p>
              @endif
            </div>
          @empty
            <div class="text-muted">Немає записів</div>
          @endforelse
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card border-success shadow-sm h-100">
        <div class="card-header bg-success text-white">Кому вже подзвонили</div>
        <div class="card-body">
          @forelse($called as $appointment)
            <div class="mb-3 pb-3 border-bottom">
              <h5 class="mb-1">{{ $appointment->name }}</h5>
              <p class="mb-1 text-muted">{{ $appointment->phone }}</p>
              <p class="mb-1 text-secondary">Послуга: {{ $appointment->service_name ?? '-' }}</p>
              <p class="small text-muted mb-0">{{ $appointment->appointment_date ? \Illuminate\Support\Carbon::parse($appointment->appointment_date)->format('d.m.Y H:i') : ($appointment->created_at ? $appointment->created_at->format('d.m.Y H:i') : 'Дата не вказана') }}</p>
              @if($appointment->notes)
                <p class="mt-2 mb-0"><small class="text-muted">Примітки: {{ $appointment->notes }}</small></p>
              @endif
            </div>
          @empty
            <div class="text-muted">Немає записів</div>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

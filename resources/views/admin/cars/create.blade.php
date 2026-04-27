@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-plus"></i> Новий Автомобіль</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary me-2">В адмін-панель</a>
            <a href="{{ route('admin.cars.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Назад до списку
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.cars.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="make" class="form-label">Марка <span class="text-danger">*</span></label>
                            <input type="text" name="make" id="make" class="form-control @error('make') is-invalid @enderror" 
                                   value="{{ old('make') }}" placeholder="Toyota, BMW, Kia..." required>
                            @error('make')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="model" class="form-label">Модель <span class="text-danger">*</span></label>
                            <input type="text" name="model" id="model" class="form-control @error('model') is-invalid @enderror" 
                                   value="{{ old('model') }}" placeholder="Camry, X5, Sportage..." required>
                            @error('model')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="year" class="form-label">Рік <span class="text-danger">*</span></label>
                            <input type="text" name="year" id="year" class="form-control @error('year') is-invalid @enderror" 
                                   value="{{ old('year') }}" placeholder="2020" maxlength="4" required>
                            @error('year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="trim" class="form-label">Комплектація (опціонально)</label>
                            <input type="text" name="trim" id="trim" class="form-control @error('trim') is-invalid @enderror" 
                                   value="{{ old('trim') }}" placeholder="SE, Sport, Limited...">
                            @error('trim')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ route('admin.cars.index') }}" class="btn btn-outline-secondary">Скасувати</a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Зберегти автомобіль
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

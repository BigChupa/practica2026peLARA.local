@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <div class="row mb-4">
    <div class="col-md-8">
      <h2>Редагування товару: <strong>{{ $product->name }}</strong></h2>
    </div>
    <div class="col-md-4 text-end">
      <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary me-2">В адмін-панель</a>
      <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Назад до товарів</a>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      @include('admin.products.form', ['product' => $product])
    </div>
  </div>
</div>
@endsection

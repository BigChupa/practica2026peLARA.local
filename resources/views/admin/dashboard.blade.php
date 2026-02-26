      
@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <div class="row mb-4">
    <div class="col-md-12">
      <h2 class="fw-bold">Адмін-панель</h2>
      <p class="text-muted">Управління категоріями, товарами, замовленнями та користувачами</p>
    </div>
  </div>
  <div class="row g-4 mt-4">
    

  <div class="row g-4">
    <div class="col-md-6 col-lg-3">
      <a href="{{ route('admin.categories.index') }}" class="text-decoration-none">
        <div class="card h-100 shadow-sm border-0 hover-shadow transition">
          <div class="card-body text-center py-5">
            <div class="display-4 text-primary mb-3">
              <i class="fas fa-list"></i>
            </div>
            <h5 class="card-title fw-bold">Категорії</h5>
            <p class="card-text text-muted">{{ $categoriesCount }} категорій</p>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-outline-primary mt-2">
              <i class="fas fa-plus"></i> Нова
            </a>
          </div>
        </div>
      </a>
    </div>

    <div class="col-md-6 col-lg-3">
      <a href="{{ route('admin.products.index') }}" class="text-decoration-none">
        <div class="card h-100 shadow-sm border-0 hover-shadow transition">
          <div class="card-body text-center py-5">
            <div class="display-4 text-success mb-3">
              <i class="fas fa-box"></i>
            </div>
            <h5 class="card-title fw-bold">Товари</h5>
            <p class="card-text text-muted">{{ $productsCount }} товарів</p>
            <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-outline-success mt-2">
              <i class="fas fa-plus"></i> Новий
            </a>
          </div>
        </div>
      </a>
    </div>

    <div class="col-md-6 col-lg-3">
      <a href="{{ route('admin.orders.index') }}" class="text-decoration-none">
        <div class="card h-100 shadow-sm border-0 hover-shadow transition">
          <div class="card-body text-center py-5">
            <div class="display-4 text-info mb-3">
              <i class="fas fa-shopping-cart"></i>
            </div>
            <h5 class="card-title fw-bold">Замовлення</h5>
            <p class="card-text text-muted">{{ $ordersCount }} замовлень</p>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-info mt-2">
              <i class="fas fa-eye"></i> Переглянути
            </a>
          </div>
        </div>
      </a>
    </div>

    <div class="col-md-6 col-lg-3">
      <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
        <div class="card h-100 shadow-sm border-0 hover-shadow transition">
          <div class="card-body text-center py-5">
            <div class="display-4 text-warning mb-3">
              <i class="fas fa-users"></i>
            </div>
            <h5 class="card-title fw-bold">Користувачі</h5>
            <p class="card-text text-muted">{{ $usersCount }} користувачів</p>
            <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-warning mt-2">
              <i class="fas fa-eye"></i> Переглянути
            </a>
          </div>
        </div>
      </a>
    </div>
      <div class="col-md-6 col-lg-3">
        <a href="{{ route('admin.sto.appointments') }}" class="text-decoration-none">
          <div class="card h-100 shadow-sm border-0 hover-shadow transition">
            <div class="card-body text-center py-5">
              <div class="display-4 text-warning mb-3">
                <i class="fas fa-users"></i>
              </div>
              <h5 class="card-title fw-bold">Записані на СТО</h5>
              <p class="card-text text-muted">{{ $stoAppointmentsCount }} Підтверджених Заявок</p>
              <p class="card-text text-muted">{{ $stoAppointmentsPendingCount }} Нових Заявок</p>
              <a href="{{ route('admin.sto.appointments') }}" class="btn btn-sm btn-outline-warning mt-2">
                <i class="fas fa-eye"></i> Переглянути
              </a>
            </div>
          </div>
        </a>
      </div>
  </div>
  </div>

</script>
  <style>
    .hover-shadow {
      transition: box-shadow 0.3s ease;
    }
    .hover-shadow:hover {
      box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important;
    }
    a.text-decoration-none:hover {
      text-decoration: none;
    }
  </style>
</div>
@endsection

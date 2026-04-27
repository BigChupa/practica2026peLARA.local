      
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
      <a href="{{ route('admin.cars.index') }}" class="text-decoration-none">
        <div class="card h-100 shadow-sm border-0 hover-shadow transition">
          <div class="card-body text-center py-5">
            <div class="display-4 text-warning mb-3">
              <i class="fas fa-car"></i>
            </div>
            <h5 class="card-title fw-bold">Автомобілі</h5>
            <p class="card-text text-muted">{{ $carsCount }} авто</p>
            <a href="{{ route('admin.cars.create') }}" class="btn btn-sm btn-outline-warning mt-2">
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

  <!-- Секція Продажів -->
  <div class="row mb-4 mt-5">
    <div class="col-md-12">
      <h3 class="fw-bold">Статистика продажів</h3>
    </div>
  </div>

  <div class="row g-4 mb-4">
    <div class="col-md-6 col-lg-3">
      <div class="card h-100 shadow-sm border-0">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="card-text text-muted mb-1">Загальні продажи</p>
              <h4 class="card-title fw-bold text-success">₴ {{ number_format($totalSales, 2, ',', ' ') }}</h4>
            </div>
            <div class="display-6 text-success">
              <i class="fas fa-chart-line"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-6 col-lg-3">
      <div class="card h-100 shadow-sm border-0">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="card-text text-muted mb-1">Продажи цього місяця</p>
              <h4 class="card-title fw-bold text-info">₴ {{ number_format($currentMonthSales, 2, ',', ' ') }}</h4>
            </div>
            <div class="display-6 text-info">
              <i class="fas fa-calendar"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-6 col-lg-3">
      <div class="card h-100 shadow-sm border-0">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="card-text text-muted mb-1">Середня вартість замовлення</p>
              <h4 class="card-title fw-bold text-warning">₴ {{ $ordersCount > 0 ? number_format($totalSales / $ordersCount, 2, ',', ' ') : '0,00' }}</h4>
            </div>
            <div class="display-6 text-warning">
              <i class="fas fa-receipt"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-6 col-lg-3">
      <div class="card h-100 shadow-sm border-0">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="card-text text-muted mb-1">Вивезено товарів</p>
              <h4 class="card-title fw-bold text-danger">{{ array_sum($productQuantities) ?? 0 }}</h4>
            </div>
            <div class="display-6 text-danger">
              <i class="fas fa-boxes"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-4 mb-4">
    <div class="col-md-6">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-header bg-light py-3 border-0">
          <h5 class="card-title mb-0 fw-bold">Топ 5 товарів за весь час</h5>
        </div>
        <div class="card-body">
          @if(!empty($topOverall))
            <ol class="list-group list-group-numbered mb-0">
              @foreach($topOverall as $item)
                <li class="list-group-item d-flex justify-content-between align-items-start">
                  <div class="ms-2 me-auto">
                    <div class="fw-bold">{{ $item['name'] }}</div>
                    <small class="text-muted">Продано: {{ $item['quantity'] }} шт.</small>
                  </div>
                  <span class="badge rounded-pill bg-primary">₴{{ number_format($item['sales'], 2, ',', ' ') }}</span>
                </li>
              @endforeach
            </ol>
          @else
            <div class="text-muted">Немає даних за товари.</div>
          @endif
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-header bg-light py-3 border-0">
          <h5 class="card-title mb-0 fw-bold">Топ 5 товарів за місяць</h5>
        </div>
        <div class="card-body">
          <form method="GET" action="{{ route('admin.dashboard') }}" class="row g-2 align-items-end mb-4">
            <div class="col-6">
              <label class="form-label small">Місяць</label>
              <select name="month" class="form-select form-select-sm">
                @foreach($months as $monthKey => $monthName)
                  <option value="{{ $monthKey }}" {{ $selectedMonth == $monthKey ? 'selected' : '' }}>{{ $monthName }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-6">
              <label class="form-label small">Рік</label>
              <select name="year" class="form-select form-select-sm">
                @foreach($years as $year)
                  <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-12 text-end">
              <button type="submit" class="btn btn-sm btn-primary">Показати</button>
            </div>
          </form>

          @if(!empty($topMonthly))
            <ol class="list-group list-group-numbered mb-0">
              @foreach($topMonthly as $item)
                <li class="list-group-item d-flex justify-content-between align-items-start">
                  <div class="ms-2 me-auto">
                    <div class="fw-bold">{{ $item['name'] }}</div>
                    <small class="text-muted">Продано: {{ $item['quantity'] }} шт.</small>
                  </div>
                  <span class="badge rounded-pill bg-success">₴{{ number_format($item['sales'], 2, ',', ' ') }}</span>
                </li>
              @endforeach
            </ol>
          @else
            <div class="text-muted">За обраний місяць немає продажів.</div>
          @endif
        </div>
      </div>
    </div>
  </div>

  <!-- Графік продажів -->
  <div class="row g-4 mb-4">
    <div class="col-md-12">
      <div class="card shadow-sm border-0">
        <div class="card-header bg-light py-3 border-0">
          <h5 class="card-title mb-0 fw-bold">ТОП 10 найпопулярніших товарів</h5>
        </div>
        <div class="card-body">
          <div style="position: relative; height: 400px;">
            <canvas id="salesChart"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>

  <!-- Chart.js Library -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const ctx = document.getElementById('salesChart').getContext('2d');
      
      const productNames = @json($productNames ?? []);
      const productSales = @json($productSales ?? []);
      const productQuantities = @json($productQuantities ?? []);

      const chart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: productNames,
          datasets: [
            {
              label: 'Сума продажів (₴)',
              data: productSales,
              backgroundColor: 'rgba(75, 192, 192, 0.7)',
              borderColor: 'rgba(75, 192, 192, 1)',
              borderWidth: 2,
              yAxisID: 'y'
            },
            {
              label: 'Кількість проданих одиниць',
              data: productQuantities,
              backgroundColor: 'rgba(255, 159, 64, 0.7)',
              borderColor: 'rgba(255, 159, 64, 1)',
              borderWidth: 2,
              yAxisID: 'y1',
              type: 'line'
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          interaction: {
            mode: 'index',
            intersect: false,
          },
          plugins: {
            legend: {
              display: true,
              position: 'top',
              labels: {
                font: {
                  size: 12
                },
                padding: 15
              }
            }
          },
          scales: {
            y: {
              type: 'linear',
              display: true,
              position: 'left',
              title: {
                display: true,
                text: 'Сума продажів (₴)',
                font: {
                  size: 12
                }
              }
            },
            y1: {
              type: 'linear',
              display: true,
              position: 'right',
              title: {
                display: true,
                text: 'Кількість одиниць',
                font: {
                  size: 12
                }
              },
              grid: {
                drawOnChartArea: false,
              }
            }
          }
        }
      });
    });
  </script>
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

@extends('layouts.admin')

@section('admin-content')
  <div class="d-flex justify-content-between mb-3">
   
  
    <h2>Продукти</h2>
    
    <div>
      <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary me-2">В адмін-панель</a>
      <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Створити новий продукт</a>
    </div>
  </div>
 
  <div class="card mb-3">
    <div class="card-body">
      <form action="{{ url()->current() }}" method="GET" class="row g-2">
        <input type="hidden" name="sort" value="{{ request('sort') }}">
        <div class="col-md-3">
          <select name="search_type" class="form-select">
            <option value="name" {{ request('search_type', 'name') === 'name' ? 'selected' : '' }}>Пошук за назвою</option>
            <option value="price" {{ request('search_type') === 'price' ? 'selected' : '' }}>Пошук за ціною</option>
          </select>
        </div>
        <div class="col-md-7">
          <input 
            type="text" 
            name="search" 
            class="form-control" 
            placeholder="Введіть назву або ціну..." 
            value="{{ request('search') }}"
          >
        </div>
        <div class="col-md-2 d-flex gap-2">
          <button type="submit" class="btn btn-primary">Знайти</button>
          <a href="{{ route('admin.products.index') }}" class="btn btn-outline-primary">Скинути</a>
        </div>
      </form>
    </div>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="table-responsive">
    <table class="table table-striped table-hover">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Назва</th>
          <th>
            @php
              $priceSort = request('sort') === 'price_asc' ? 'price_desc' : 'price_asc';
            @endphp
            <a href="{{ route('admin.products.index', array_merge(request()->query(), ['sort' => $priceSort])) }}" class="text-white text-decoration-none">
              Ціна
              @if(request('sort') === 'price_asc')
                <i class="fas fa-sort-amount-up-alt ms-1"></i>
              @elseif(request('sort') === 'price_desc')
                <i class="fas fa-sort-amount-down-alt ms-1"></i>
              @else
                <i class="fas fa-sort ms-1"></i>
              @endif
            </a>
          </th>
          <th>
            @php
              $stockSort = request('sort') === 'stock_asc' ? 'stock_desc' : 'stock_asc';
            @endphp
            <a href="{{ route('admin.products.index', array_merge(request()->query(), ['sort' => $stockSort])) }}" class="text-white text-decoration-none">
              На складі
              @if(request('sort') === 'stock_asc')
                <i class="fas fa-sort-amount-up-alt ms-1"></i>
              @elseif(request('sort') === 'stock_desc')
                <i class="fas fa-sort-amount-down-alt ms-1"></i>
              @else
                <i class="fas fa-sort ms-1"></i>
              @endif
            </a>
          </th>
          <th>Дії</th>
        </tr>
      </thead>
    <tbody>
      @forelse($products as $product)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>
          <div class="d-flex align-items-center gap-2">
            @if($product->image_path)
              <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="img-thumbnail" style="max-width: 50px; height: auto;">
            @else
              <img src="{{ asset('storage/image/121.png') }}" alt="{{ $product->name }}" class="img-thumbnail" style="max-width: 50px; height: auto;">
            @endif
            <span>{{ $product->name }}</span>
          </div>
        </td>
        <td>{{ $product->price }}</td>
        <td>{{ $product->stock_quantity ?? 0 }}</td>
        <td>
      <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-secondary">Редагувати</a>
          <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display:inline-block">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger" onclick="return confirm('Видалити?')">Видалити</button>
          </form>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="5" class="text-center">Товарів не знайдено</td>
      </tr>
      @endforelse
    </tbody>
    </table>
  </div>

  {{ $products->appends(['search' => request('search'), 'search_type' => request('search_type'), 'sort' => request('sort')])->links('vendor.pagination.simple-custom') }}

@endsection
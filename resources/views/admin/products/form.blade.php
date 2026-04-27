@php
  $isEdit = isset($product);
  $action = $isEdit ? route('admin.products.update', $product) : route('admin.products.store');
  $method = $isEdit ? 'PUT' : 'POST';
@endphp

@if($errors->any())
  <div class="alert alert-danger">
    <ul>
      @foreach($errors->all() as $err)
        <li>{{ $err }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
  @csrf
  @if($isEdit) @method('PUT') @endif

  <div class="mb-3">
    <label class="form-label">Назва товару <span class="text-danger">*</span></label>
    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name ?? '') }}" required>
    @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
  </div>

  <div class="mb-3">
    <label class="form-label">Ціна <span class="text-danger">*</span></label>
    <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price ?? '') }}" required>
    @error('price') <span class="invalid-feedback">{{ $message }}</span> @enderror
  </div>

  <div class="mb-3">
    <label class="form-label">Категорія</label>
    <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
      <option value="">-- Виберіть категорію --</option>
      @foreach($categories as $category)
        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
          {{ $category->name }}
        </option>
      @endforeach
    </select>
    @error('category_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
  </div>

  <div class="mb-3">
    <label class="form-label">Автомобіль (опціонально)</label>
    <select name="car_id" class="form-control @error('car_id') is-invalid @enderror">
      <option value="">-- Не привязаний до авто --</option>
      @foreach($cars as $car)
        <option value="{{ $car->id }}" {{ old('car_id', $product->car_id ?? '') == $car->id ? 'selected' : '' }}>
          {{ $car->make }} {{ $car->model }} ({{ $car->year }})
        </option>
      @endforeach
    </select>
    <small class="text-muted">Вибір авто автоматично заповнить сумісність</small>
    @error('car_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
  </div>

  <div class="mb-3">
    <label class="form-label">Виробіток (шт.)</label>
    <input type="number" name="stock_quantity" class="form-control @error('stock_quantity') is-invalid @enderror" value="{{ old('stock_quantity', $product->stock_quantity ?? '0') }}" min="0">
    @error('stock_quantity') <span class="invalid-feedback">{{ $message }}</span> @enderror
  </div>

  <div class="mb-3">
    <label class="form-label">Опис</label>
    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $product->description ?? '') }}</textarea>
    @error('description') <span class="invalid-feedback">{{ $message }}</span> @enderror
  </div>

  <div class="mb-3">
    <label class="form-label">Зображення товару</label>
    @if($isEdit && $product->image_path)
      <div class="mb-2">
        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" style="max-width: 200px; max-height: 200px;">
      </div>
    @endif
    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
    <small class="text-muted">Максимальний розмір: 2 МБ</small>
    @error('image') <span class="invalid-feedback">{{ $message }}</span> @enderror
  </div>

  <div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary">
      {{ $isEdit ? 'Оновити товар' : 'Створити товар' }}
    </button>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Скасувати</a>
  </div>
</form>

@extends('layouts.admin')

@section('admin-content')
  <div class="d-flex justify-content-between mb-3">
    <h2>Products</h2>
    <div>
      <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary me-2">В адмін-панель</a>
      <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Create product</a>
    </div>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <table class="table table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>Name</th>
        <th>Price</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($products as $product)
      <tr>
        <td>{{ $product->id }}</td>
        <td>{{ $product->name }}</td>
        <td>{{ $product->price }}</td>
        <td>
          <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-secondary">Edit</a>
          <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display:inline-block">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  {{ $products->links('vendor.pagination.simple-custom') }}

@endsection

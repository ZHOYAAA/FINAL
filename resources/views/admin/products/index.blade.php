@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Products</h5>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="bi bi-plus"></i> Add Product
        </a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            @foreach($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="{{ $product->image }}" 
                         class="card-img-top" 
                         alt="{{ $product->title }}" 
                         style="height: 200px; object-fit: cover;"
                         onerror="this.src='{{ asset('images/no-image.png') }}'">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->title }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($product->description, 100) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-primary">{{ $product->category->title }}</span>
                            <h6 class="mb-0">Rp {{ number_format($product->price, 0, ',', '.') }}</h6>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-top-0">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection 
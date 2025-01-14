@extends('admin.layouts.app')
@php
use Illuminate\Support\Str;
@endphp

@section('content')
<!-- Statistik Cards Row -->
<div class="row">
    <!-- Total Categories -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Categories</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Category::count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-grid fs-2 text-primary"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light">
                <a href="{{ route('admin.categories.index') }}" class="text-primary text-decoration-none small">
                    View Details <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Total Products -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Products</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Product::count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-box fs-2 text-success"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light">
                <a href="{{ route('admin.products.index') }}" class="text-success text-decoration-none small">
                    View Details <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Total Sliders -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Sliders</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Slider::count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-images fs-2 text-info"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light">
                <a href="{{ route('admin.sliders.index') }}" class="text-info text-decoration-none small">
                    View Details <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Total Users -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Users</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\User::count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-people fs-2 text-warning"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light">
                <span class="text-warning small">Registered Users</span>
            </div>
        </div>
    </div>
</div>

<!-- Grafik Statistik Row -->
<div class="row">
    <!-- Products per Category Chart -->
    <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Products per Category</h6>
            </div>
            <div class="card-body">
                <canvas id="productsPerCategoryChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Monthly Users Registration Chart -->
    <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-warning">Monthly User Registrations</h6>
            </div>
            <div class="card-body">
                <canvas id="userRegistrationsChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="row">
    <!-- Latest Products -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Latest Products</h6>
                <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus"></i> Add Product
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Models\Product::with('category')->latest()->take(5)->get() as $product)
                            <tr>
                                <td>
                                    <img src="{{ $product->image }}" alt="{{ $product->title }}" 
                                         style="width: 50px; height: 50px; object-fit: cover;"
                                         class="rounded">
                                </td>
                                <td>{{ $product->title }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ $product->category->title }}</span>
                                </td>
                                <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Sliders -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-info">Active Sliders</h6>
                <a href="{{ route('admin.sliders.create') }}" class="btn btn-sm btn-info">
                    <i class="bi bi-plus"></i> Add Slider
                </a>
            </div>
            <div class="card-body">
                @foreach(\App\Models\Slider::latest()->take(3)->get() as $slider)
                <div class="mb-3">
                    <img src="{{ $slider->image }}" alt="{{ $slider->title }}" 
                         class="img-fluid rounded mb-2 w-100" style="height: 120px; object-fit: cover;">
                    <h6 class="mb-1">{{ $slider->title }}</h6>
                    <p class="small text-muted mb-0">{{ $slider->subtitle }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="row">
    <!-- Categories List -->
    <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-success">Categories Overview</h6>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-success">
                    <i class="bi bi-plus"></i> Add Category
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Products</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Models\Category::withCount('products')->get() as $category)
                            <tr>
                                <td>{{ $category->title }}</td>
                                <td>
                                    <span class="badge bg-success">{{ $category->products_count }}</span>
                                </td>
                                <td>{{ Str::limit($category->description, 50) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Users -->
    <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-warning">Latest Users</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Models\User::latest()->take(5)->get() as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @foreach($user->roles as $role)
                                        <span class="badge bg-{{ $role->name == 'admin' ? 'danger' : 'warning' }}">
                                            {{ $role->name }}
                                        </span>
                                    @endforeach
                                </td>
                                <td>{{ $user->created_at->diffForHumans() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.border-left-primary {
    border-left: 4px solid #4e73df !important;
}
.border-left-success {
    border-left: 4px solid #1cc88a !important;
}
.border-left-info {
    border-left: 4px solid #36b9cc !important;
}
.border-left-warning {
    border-left: 4px solid #f6c23e !important;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Data untuk grafik Products per Category
    const categoryData = @json(\App\Models\Category::withCount('products')->get()->map(function($category) {
        return [
            'label' => $category->title,
            'count' => $category->products_count
        ];
    }));

    new Chart(document.getElementById('productsPerCategoryChart'), {
        type: 'bar',
        data: {
            labels: categoryData.map(item => item.label),
            datasets: [{
                label: 'Number of Products',
                data: categoryData.map(item => item.count),
                backgroundColor: '#4e73df',
                borderColor: '#4e73df',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Data untuk grafik Monthly User Registrations
    const monthlyUsers = @json(
        DB::select("
            SELECT DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count 
            FROM users 
            GROUP BY month 
            ORDER BY month DESC 
            LIMIT 6
        ")
    );

    new Chart(document.getElementById('userRegistrationsChart'), {
        type: 'line',
        data: {
            labels: monthlyUsers.map(item => {
                const date = new Date(item.month);
                return date.toLocaleDateString('id-ID', { month: 'short', year: 'numeric' });
            }),
            datasets: [{
                label: 'New Users',
                data: monthlyUsers.map(item => item.count),
                borderColor: '#f6c23e',
                backgroundColor: 'rgba(246, 194, 62, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>
@endpush 
@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Sliders</h5>
        <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary">
            <i class="bi bi-plus"></i> Add Slider
        </a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Subtitle</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sliders as $slider)
                    <tr>
                        <td>
                            <img src="{{ $slider->image }}" 
                                 alt="{{ $slider->title }}" 
                                 class="img-thumbnail"
                                 style="height: 100px; object-fit: cover;"
                                 onerror="this.src='{{ asset('images/no-image.png') }}'">
                        </td>
                        <td>{{ $slider->title }}</td>
                        <td>{{ $slider->subtitle }}</td>
                        <td>
                            <a href="{{ route('admin.sliders.edit', $slider) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.sliders.destroy', $slider) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 
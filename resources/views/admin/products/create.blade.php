@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Add New Product</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.products.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}">
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}">
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->title }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Image URL</label>
                <input type="url" class="form-control @error('image') is-invalid @enderror" id="image" name="image" value="{{ old('image') }}" placeholder="https://example.com/image.jpg" onchange="previewImage(this)">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="mt-2">
                    <img id="imagePreview" src="#" alt="Preview" style="max-width: 200px; display: none;">
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Save Product</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function previewImage(input) {
    var preview = document.getElementById('imagePreview');
    if (input.value) {
        preview.src = input.value;
        preview.style.display = 'block';
    } else {
        preview.style.display = 'none';
    }
}
</script>
@endpush
@endsection 
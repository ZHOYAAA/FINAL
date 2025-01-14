@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Add New Slider</h5>
        <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.sliders.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                       id="title" name="title" value="{{ old('title') }}">
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="subtitle" class="form-label">Subtitle</label>
                <input type="text" class="form-control @error('subtitle') is-invalid @enderror" 
                       id="subtitle" name="subtitle" value="{{ old('subtitle') }}">
                @error('subtitle')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Image URL</label>
                <input type="url" class="form-control @error('image') is-invalid @enderror" 
                       id="image" name="image" value="{{ old('image') }}"
                       placeholder="https://example.com/image.jpg"
                       onchange="previewImage(this)">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="mt-2">
                    <img id="imagePreview" src="#" alt="Preview" 
                         style="max-width: 300px; display: none;"
                         class="img-thumbnail">
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg"></i> Save Slider
                </button>
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
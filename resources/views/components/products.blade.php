<div class="row">
    @foreach($products as $product)
    <div class="col-lg-4 col-md-6 mb-4">
      <div class="card">
        <img src="{{ $product->image }}" 
             class="card-img-top" 
             alt="{{ $product->title }}"
             style="height: 200px; object-fit: cover;"
             onerror="this.src='{{ asset('images/no-image.png') }}'">
        <div class="card-body">
          <h5 class="card-title">{{ $product->title }}</h5>
          <a href="/product/{{ $product->id }}" class="btn btn-primary">Detail Product</a>
        </div>
      </div>
    </div>
    @endforeach
  </div>
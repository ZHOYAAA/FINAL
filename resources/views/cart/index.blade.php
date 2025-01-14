<x-layout :$menu :$submenu :$categories :$appname>
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 font-weight-bold">Keranjang Belanja</h5>
                    </div>
                    <div class="card-body">
                        @if($cartItems->count() > 0)
                            @foreach($cartItems as $item)
                                <div class="row mb-4 d-flex justify-content-between align-items-center">
                                    <div class="col-md-2 col-lg-2 col-xl-2">
                                        <img src="{{ $item->product->image }}" 
                                             class="img-fluid rounded" alt="{{ $item->product->title }}">
                                    </div>
                                    <div class="col-md-3 col-lg-3 col-xl-3">
                                        <h6 class="text-black mb-0">{{ $item->product->title }}</h6>
                                        <small class="text-muted">{{ $item->product->category->title }}</small>
                                    </div>
                                    <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
                                        <form action="{{ route('cart.update', $item) }}" method="POST" class="d-flex align-items-center">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" name="decrease" class="btn btn-outline-secondary btn-sm" 
                                                    onclick="this.form.querySelector('input[name=quantity]').value--;">
                                                <i class="bi bi-dash"></i>
                                            </button>

                                            <input type="number" name="quantity" class="form-control form-control-sm mx-2 text-center" 
                                                   value="{{ $item->quantity }}" min="1" style="width: 60px">

                                            <button type="submit" name="increase" class="btn btn-outline-secondary btn-sm"
                                                    onclick="this.form.querySelector('input[name=quantity]').value++;">
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                                        <h6 class="mb-0">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</h6>
                                    </div>
                                    <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                                        <form action="{{ route('cart.destroy', $item) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link text-danger" 
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini dari keranjang?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @if(!$loop->last)
                                    <hr class="my-4">
                                @endif
                            @endforeach
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-cart-x display-1 text-muted"></i>
                                <p class="mt-3">Keranjang belanja Anda kosong</p>
                                <a href="/" class="btn btn-primary">
                                    Mulai Belanja
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 font-weight-bold">Ringkasan Belanja</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Total Barang</h6>
                            <h6>{{ $cartItems->sum('quantity') }} item</h6>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <h6>Total Harga</h6>
                            <h6 class="text-primary">Rp {{ number_format($total, 0, ',', '.') }}</h6>
                        </div>
                        <form action="{{ route('checkout.process') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100"
                                    {{ $cartItems->count() == 0 ? 'disabled' : '' }}>
                                Lanjut ke Pembayaran
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout> 
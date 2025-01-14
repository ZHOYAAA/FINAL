@auth
    @php
        $cartCount = \App\Models\Cart::where('user_id', auth()->id())->sum('quantity');
    @endphp
    <a href="{{ route('cart.index') }}" class="nav-link position-relative">
        <i class="bi bi-cart3 fs-5"></i>
        @if($cartCount > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ $cartCount }}
                <span class="visually-hidden">items in cart</span>
            </span>
        @endif
    </a>
@else
    <a href="{{ route('login') }}" class="nav-link">
        <i class="bi bi-cart3 fs-5"></i>
    </a>
@endauth 
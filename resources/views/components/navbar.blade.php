<nav class="navbar fixed-top shadow navbar-expand-lg navbar-light bg-light mt-lg-4 rounded">
    <div class="container">
        <a class="navbar-brand" href="/">{{ $appname }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/">Home</a>
                </li>
                @foreach($menu as $mn)
                <li class="nav-item">
                    <a class="nav-link" href="/page/{{ $mn->id }}">{{ $mn->name }}</a>
                </li>
                @endforeach
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Pages
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @foreach($submenu as $sm)
                        <li><a class="dropdown-item" href="/page/{{ $sm->id }}">{{ $sm->name }}</a></li>
                        @endforeach
                    </ul>
                </li>

                @guest
                    <!-- Tampilkan jika belum login -->
                    <li class="nav-item me-2">
                        <a class="nav-link btn btn-outline-primary rounded" href="#" data-bs-toggle="modal" data-bs-target="#registerModal">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary rounded text-white" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
                    </li>
                @else
                    <!-- Tampilkan jika sudah login -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-1"></i>
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            @if(Auth::user()->isAdmin())
                                <li>
                                    <a class="dropdown-item" href="/admin">
                                        <i class="bi bi-speedometer2 me-2"></i>
                                        Dashboard
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                            @endif
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest

                <!-- Cart -->
                <li class="nav-item ms-2">
                    <x-cart-count />
                </li>
            </ul>
        </div>
    </div>
</nav>
{{-- Navbar expanded --}}
<div class="py-4 mt-3 py-lg-0 mt-lg-0"></div>
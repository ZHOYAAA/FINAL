<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        #sidebar {
            min-height: 100vh;
            width: 250px;
            transition: all 0.3s;
        }
        #sidebar.collapsed {
            margin-left: -250px;
        }
        #content {
            width: calc(100% - 250px);
            transition: all 0.3s;
        }
        #content.expanded {
            width: 100%;
        }
        .sidebar-link {
            color: #fff;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
            transition: all 0.3s;
        }
        .sidebar-link:hover {
            background: rgba(255,255,255,0.1);
            color: #fff;
            padding-left: 20px;
        }
        .sidebar-link.active {
            background: rgba(255,255,255,0.2);
            border-left: 4px solid #fff;
        }
        .nav-item {
            margin-bottom: 5px;
        }
        .sidebar-icon {
            width: 20px;
            text-align: center;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div id="sidebar" class="bg-dark text-white">
            <div class="p-3">
                <h4 class="text-white d-flex align-items-center">
                    <i class="bi bi-speedometer2 me-2"></i>
                    Admin Panel
                </h4>
                <hr>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" 
                           class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="bi bi-house-door sidebar-icon"></i> Dashboard
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="{{ route('admin.products.index') }}" 
                           class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                            <i class="bi bi-box sidebar-icon"></i> Products
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.categories.index') }}" 
                           class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                            <i class="bi bi-grid sidebar-icon"></i> Categories
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.sliders.index') }}" 
                           class="sidebar-link {{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}">
                            <i class="bi bi-images sidebar-icon"></i> Sliders
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}" 
                           class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i class="bi bi-people sidebar-icon"></i> Users
                        </a>
                    </li>

                    <!-- Tambahkan menu lain di sini -->
                    <li class="nav-item mt-4">
                        <a href="/" class="sidebar-link">
                            <i class="bi bi-arrow-left-circle sidebar-icon"></i> Back to Site
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Content -->
        <div id="content">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <button id="sidebarToggle" class="btn btn-outline-dark">
                        <i class="bi bi-list"></i>
                    </button>
                    <div class="ms-auto d-flex align-items-center">
                        <div class="dropdown">
                            <button class="btn btn-outline-dark dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-2"></i>
                                {{ Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="container-fluid p-4">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('collapsed');
            document.getElementById('content').classList.toggle('expanded');
        });
    </script>
</body>
</html> 
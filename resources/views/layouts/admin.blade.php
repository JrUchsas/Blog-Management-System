<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - Blog Management System</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom Admin Styles -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    
    @yield('styles')
</head>
<body>

    <div id="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h4>BlogAdmin</h4>
            </div>

            <ul class="list-unstyled components">
                <!-- Dashboard Menu -->
                <li class="{{ Route::is('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>

                <!-- Authentication Menu -->
                <li>
                    <a href="#authSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="bi bi-shield-check"></i> Authentication
                    </a>
                    <ul class="collapse list-unstyled submenu-list show" id="authSubmenu">
                        @guest
                            <li class="{{ Route::is('login') ? 'active' : '' }}">
                                <a href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right"></i> Login</a>
                            </li>
                        @else
                            <li>
                                <a href="#" onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </a>
                            </li>
                        @endguest
                    </ul>
                </li>

                <!-- Category Menu -->
                <li>
                    <a href="#categorySubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="bi bi-tags"></i> Category
                    </a>
                    <ul class="collapse list-unstyled submenu-list show" id="categorySubmenu">
                        <li class="{{ Route::is('admin.categories.create') ? 'active' : '' }}">
                            <a href="{{ route('admin.categories.create') }}"><i class="bi bi-plus-circle"></i> Add Category</a>
                        </li>
                        <li class="{{ Route::is('admin.categories.index') || Route::is('admin.categories.edit') ? 'active' : '' }}">
                            <a href="{{ route('admin.categories.index') }}"><i class="bi bi-list-ul"></i> Category List</a>
                        </li>
                    </ul>
                </li>

                <!-- Blog Menu -->
                <li>
                    <a href="#blogSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="bi bi-file-earmark-post"></i> Blog
                    </a>
                    <ul class="collapse list-unstyled submenu-list show" id="blogSubmenu">
                        <li class="{{ Route::is('admin.blogs.create') ? 'active' : '' }}">
                            <a href="{{ route('admin.blogs.create') }}"><i class="bi bi-pencil-square"></i> Add Blog</a>
                        </li>
                        <li class="{{ Route::is('admin.blogs.index') || Route::is('admin.blogs.edit') || Route::is('admin.blogs.show') ? 'active' : '' }}">
                            <a href="{{ route('admin.blogs.index') }}"><i class="bi bi-list-ul"></i> Blog List</a>
                        </li>
                    </ul>
                </li>

                <!-- Profile Menu -->
                <li>
                    <a href="#profileSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="bi bi-person-circle"></i> Profile
                    </a>
                    <ul class="collapse list-unstyled submenu-list show" id="profileSubmenu">
                        <li class="{{ Route::is('admin.profile.change-password') ? 'active' : '' }}">
                            <a href="{{ route('admin.profile.change-password') }}"><i class="bi bi-key"></i> Change Password</a>
                        </li>
                        <li>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

            <!-- Hidden Logout Form -->
            <form id="sidebar-logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <!-- Top Navbar -->
            <nav class="navbar navbar-expand-lg navbar-custom">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-outline-secondary">
                        <i class="bi bi-justify"></i>
                    </button>
                    
                    <div class="ms-auto d-flex align-items-center">
                        @auth
                            <span class="me-3 text-muted">Welcome, <strong>{{ Auth::user()->name }}</strong></span>
                            <button class="btn btn-outline-danger btn-sm" onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        @endauth
                    </div>
                </div>
            </nav>

            <!-- Alerts -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert" style="border-radius: 12px;">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert" style="border-radius: 12px;">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> Please fix the errors below:
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Main Content Yield -->
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap 5 Bundle JS (with Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Sidebar Toggle Script -->
    <script>
        document.getElementById('sidebarCollapse').addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('active');
        });
    </script>
    
    @yield('scripts')
</body>
</html>

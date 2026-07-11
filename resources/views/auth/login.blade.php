<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Blog Management System</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>
<body>

    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="text-center mb-4">
                <i class="bi bi-person-workspace text-primary" style="font-size: 3rem;"></i>
                <h3 class="auth-title mt-2">Welcome Back</h3>
                <p class="auth-subtitle">Login to access your Blog Admin Dashboard</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 mb-3" role="alert" style="border-radius: 10px;">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show border-0 mb-3" role="alert" style="border-radius: 10px;">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label font-weight-bold">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0" style="border-radius: 10px 0 0 10px;"><i class="bi bi-envelope text-muted"></i></span>
                        <input type="email" class="form-control border-start-0" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required style="border-radius: 0 10px 10px 0;">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label font-weight-bold">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0" style="border-radius: 10px 0 0 10px;"><i class="bi bi-lock text-muted"></i></span>
                        <input type="password" class="form-control border-start-0" id="password" name="password" placeholder="Enter password" required style="border-radius: 0 10px 10px 0;">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3">Sign In</button>
            </form>

            <div class="text-center mt-3">
                <span class="text-muted">Don't have an account? </span>
                <a href="{{ route('register') }}" class="auth-link">Register here</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

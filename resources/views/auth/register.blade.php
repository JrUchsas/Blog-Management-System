<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Blog Management System</title>
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
                <i class="bi bi-person-plus text-primary" style="font-size: 3rem;"></i>
                <h3 class="auth-title mt-2">Create Account</h3>
                <p class="auth-subtitle">Register to manage categories and blog posts</p>
            </div>

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

            <form action="{{ route('register') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="name" class="form-label font-weight-bold">Full Name</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0" style="border-radius: 10px 0 0 10px;"><i class="bi bi-person text-muted"></i></span>
                        <input type="text" class="form-control border-start-0" id="name" name="name" value="{{ old('name') }}" placeholder="Enter full name" required style="border-radius: 0 10px 10px 0;">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label font-weight-bold">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0" style="border-radius: 10px 0 0 10px;"><i class="bi bi-envelope text-muted"></i></span>
                        <input type="email" class="form-control border-start-0" id="email" name="email" value="{{ old('email') }}" placeholder="Enter email address" required style="border-radius: 0 10px 10px 0;">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label font-weight-bold">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0" style="border-radius: 10px 0 0 10px;"><i class="bi bi-lock text-muted"></i></span>
                        <input type="password" class="form-control border-start-0" id="password" name="password" placeholder="Min. 8 characters" required style="border-radius: 0 10px 10px 0;">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label font-weight-bold">Confirm Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0" style="border-radius: 10px 0 0 10px;"><i class="bi bi-shield-lock text-muted"></i></span>
                        <input type="password" class="form-control border-start-0" id="password_confirmation" name="password_confirmation" placeholder="Repeat password" required style="border-radius: 0 10px 10px 0;">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3">Sign Up</button>
            </form>

            <div class="text-center mt-3">
                <span class="text-muted">Already have an account? </span>
                <a href="{{ route('login') }}" class="auth-link">Login here</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

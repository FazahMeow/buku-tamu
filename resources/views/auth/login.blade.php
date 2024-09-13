<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container-fluid h-100">
        <div class="row h-100">
            <div class="col-12 d-flex align-items-center justify-content-center">
                <div class="login-card">
                    <img src="{{ asset('images/bpsdin-logo.png') }}" alt="BPSDIN Logo" class="logo mb-4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="password-input">
                                <input type="password" class="form-control" id="password" name="password" required>
                                <span class="password-toggle">👁️</span>
                            </div>
                        </div>
                        <div class="text-end mb-3">
                            <a href="#" class="forgot-password">Lupa Password?</a>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-login">LOGIN</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('js/login.js') }}"></script>
</body>
</html>
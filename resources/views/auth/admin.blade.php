{{-- resources/views/auth/admin-login.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #0a1931, #1a3c6e);
            height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-container {
            height: 100vh;
        }

        .login-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 360px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.25);
            animation: fadeIn 0.6s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo-circle {
            width: 65px;
            height: 65px;
            background: #0a1931;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px auto;
            color: white;
            font-weight: bold;
            font-size: 22px;
        }

        .login-title {
            color: #0a1931;
            font-weight: 700;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px;
            border: 1px solid #dce3f1;
        }

        .form-control:focus {
            border-color: #1a3c6e;
            box-shadow: none;
        }

        .btn-navy {
            background: #0a1931;
            color: white;
            border-radius: 10px;
            padding: 10px;
            transition: 0.3s;
        }

        .btn-navy:hover {
            background: #1a3c6e;
            color: white;
        }

        .footer-text {
            font-size: 12px;
            color: #7a8bb3;
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>

<body>

<div class="d-flex justify-content-center align-items-center login-container">

    <form method="POST" action="{{ route('admin.login.submit') }}" class="login-card">
        @csrf

        <div class="text-center">
            <div class="logo-circle">
                🛡️
            </div>
            <h4 class="login-title mb-4">Admin Login</h4>
        </div>

        <input type="email"
               name="email"
               class="form-control mb-3"
               placeholder="Email"
               required>

        <input type="password"
               name="password"
               class="form-control mb-4"
               placeholder="Password"
               required>

        <button class="btn btn-navy w-100">
            Login
        </button>

        <div class="footer-text">
            Secure Admin Access
        </div>
    </form>

</div>

</body>
</html>
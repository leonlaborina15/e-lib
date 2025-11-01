<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - D-Library</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="js/bootstrap.bundle.js"></script>

    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        body {
            min-height: 100vh;
            height: 100%;
            background: radial-gradient(circle at 35% 20%, #e5e5e7 0%, #cacace 100%);
        }
        .login-overlay {
            position: fixed;
            top: 0; left: 0;
            width: 100vw; height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 999;
        }
        .login-card {
            border-radius: 1.25rem;
            box-shadow: 0 8px 40px rgba(30, 30, 30, 0.14);
            background: #fff;
            border: none;
            max-width: 410px;
            width: 100%;
        }
        .card-body {
            padding: 2.5rem;
        }
        .login-logo {
            width: 64px;
            height: 64px;
            object-fit: contain;
            display: inline-block;
        }
        .login-title {
            font-size: 2.25rem;
            font-weight: 700;
            color: #23272f;
            margin-top: 1rem;
            margin-bottom: 0.3rem;
            letter-spacing: -1px;
        }
        .login-subtitle {
            color: #4b4b52;
            font-size: 1.05rem;
            margin-bottom: 1.6rem;
        }
        .form-label {
            color: #23272f;
            font-weight: 500;
        }
        .form-control {
            border-radius: 0.55rem;
            border: 1px solid #d7d7db;
            font-size: 1.08rem;
            background: #f8f8fa;
        }
        .form-control:focus {
            border-color: #23272f;
            box-shadow: 0 0 0 0.15rem rgba(60,60,60,0.10);
            background: #fff;
        }
        .btn-login {
            background: linear-gradient(90deg, #23272f 0%, #444851 100%);
            color: #fff;
            font-size: 1.12rem;
            font-weight: 600;
            border-radius: 0.8rem;
            border: none;
            transition: background .17s, box-shadow .17s;
            box-shadow: 0 2px 8px rgba(60,60,60,0.08);
        }
        .btn-login:hover, .btn-login:focus {
            background: linear-gradient(90deg, #444851 0%, #23272f 100%);
            color: #fff;
            box-shadow: 0 4px 16px rgba(60,60,60,0.13);
        }
        .register-link {
            color: #23272f;
            text-decoration: underline;
            font-weight: 500;
            transition: color .15s;
        }
        .register-link:hover {
            color: #444851;
            text-decoration: underline;
        }
        @media (max-width: 575.98px) {
            .card-body {
                padding: 1.2rem;
            }
            .login-title {
                font-size: 1.5rem;
            }
            .login-logo {
                width: 44px;
                height: 44px;
            }
            .login-card {
                max-width: 98vw;
                margin: 18px !important; /* Add margin for mobile! */
            }
        }
        @media (max-height: 480px) {
            .login-overlay {
                align-items: flex-start;
                padding-top: 20px;
                height: auto;
                min-height: 100vh;
                overflow-y: auto !important;
            }
        }
    </style>
</head>
<body>
    <div class="login-overlay">
        <div class="card login-card shadow">
            <div class="card-body">
                <div class="text-center mb-3">
                    <img src="<?= BASE_URL ?>assets/logo1.png" alt="D-Library Logo" class="login-logo mb-2">
                    <div class="login-title">D-Library System</div>
                    <div class="login-subtitle">Sign in to your account</div>
                </div>

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= $_SESSION['success'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $_SESSION['error'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" required autofocus>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="d-grid gap-2 mb-2">
                        <button type="submit" class="btn btn-login btn-lg">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Login
                        </button>
                    </div>
                    <div class="text-center mt-3">
                        <span class="text-muted">Don't have an account?
                            <a href="<?= BASE_URL ?>?route=register" class="register-link">Register here</a>
                        </span>
                    </div>
                </form>
                <hr class="my-4">
            </div>
        </div>
    </div>
</body>
</html>
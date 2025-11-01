<?php require_once BASE_PATH . '/app/views/layouts/header.php'; ?>

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
.register-overlay {
    position: fixed;
    top: 0; left: 0;
    width: 100vw; height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 999;
}
.register-card {
    border-radius: 1.25rem;
    box-shadow: 0 8px 40px rgba(30, 30, 30, 0.14);
    background: #fff;
    border: none;
    max-width: 430px;
    width: 100%;
}
.card-body {
    padding: 2.3rem;
}
.register-logo {
    width: 62px;
    height: 62px;
    object-fit: contain;
    border-radius: 16px;
    background: #f3f4f8;
    display: inline-block;
}
.register-title {
    font-size: 2.05rem;
    font-weight: 700;
    color: #23272f;
    margin-top: 1rem;
    margin-bottom: 0.3rem;
    letter-spacing: -1px;
}
.register-subtitle {
    color: #4b4b52;
    font-size: 1.02rem;
    margin-bottom: 1.5rem;
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
.btn-register {
    background: linear-gradient(90deg, #23272f 0%, #444851 100%);
    color: #fff;
    font-size: 1.12rem;
    font-weight: 600;
    border-radius: 0.8rem;
    border: none;
    transition: background .17s, box-shadow .17s;
    box-shadow: 0 2px 8px rgba(60,60,60,0.08);
}
.btn-register:hover, .btn-register:focus {
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
    .register-title {
        font-size: 1.3rem;
    }
    .register-logo {
        width: 40px;
        height: 40px;
    }
    .register-card {
        max-width: 98vw;
    }
}
/* Allow scroll only if screen is super small */
@media (max-height: 480px) {
    .register-overlay {
        align-items: flex-start;
        padding-top: 20px;
        height: auto;
        min-height: 100vh;
        overflow-y: auto !important;
    }
}

</style>

<div class="register-overlay">
    <div class="card register-card shadow">
        <div class="card-body">
            <div class="text-center mb-4">
                <img src="<?= BASE_URL ?>assets/logo1.png" alt="D-Library Logo" class="register-logo mb-2">
                <div class="register-title">Create Account</div>
                <div class="register-subtitle">Register to access E-Library</div>
            </div>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?= $_SESSION['error'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <form method="POST" action="<?= BASE_URL ?>?route=register">
                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-person me-1"></i>Full Name</label>
                    <input type="text" name="name" class="form-control" required autocomplete="name">
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-envelope me-1"></i>Email Address</label>
                    <input type="email" name="email" class="form-control" required autocomplete="email">
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-key me-1"></i>Password</label>
                    <input type="password" name="password" class="form-control" required minlength="6" autocomplete="new-password">
                    <small class="text-muted">Minimum 6 characters</small>
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-key-fill me-1"></i>Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control" required autocomplete="new-password">
                </div>

                <button type="submit" class="btn btn-register btn-lg w-100">
                    <i class="bi bi-person-check"></i> Register
                </button>
            </form>

            <div class="text-center mt-4">
                <p>Already have an account? <a href="<?= BASE_URL ?>?route=login" class="register-link">Login here</a></p>
            </div>
        </div>
    </div>
</div>

<?php require_once BASE_PATH . '/app/views/layouts/footer.php'; ?>
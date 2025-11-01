<?php

require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/sidebar.php';
?>

<!-- Main Content - No Duplicate Headers -->
<div class="card shadow-sm">
    <div class="card-header bg-white border-bottom">
        <h5 class="card-title mb-0">
            <i class="bi bi-person-plus-fill me-2"></i>
            User Information
        </h5>
    </div>
    <div class="card-body">
        <form method="POST" action="<?= BASE_URL ?>?route=users/create" class="needs-validation" novalidate>
            <!-- Basic Information -->
            <div class="row g-3">
                <!-- Full Name -->
                <div class="col-md-6">
                    <label for="name" class="form-label">
                        Full Name <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           class="form-control"
                           id="name"
                           name="name"
                           placeholder="Enter full name"
                           required>
                    <div class="invalid-feedback">
                        Please enter a full name.
                    </div>
                </div>

                <!-- Email -->
                <div class="col-md-6">
                    <label for="email" class="form-label">
                        Email Address <span class="text-danger">*</span>
                    </label>
                    <input type="email"
                           class="form-control"
                           id="email"
                           name="email"
                           placeholder="user@example.com"
                           required>
                    <div class="invalid-feedback">
                        Please enter a valid email address.
                    </div>
                </div>

                <!-- Password -->
                <div class="col-md-6">
                    <label for="password" class="form-label">
                        Password <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <input type="password"
                               class="form-control"
                               id="password"
                               name="password"
                               placeholder="Minimum 6 characters"
                               minlength="6"
                               required>
                        <button class="btn btn-outline-secondary"
                                type="button"
                                onclick="togglePassword('password', this)">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <small class="text-muted">Minimum 6 characters</small>
                    <div class="invalid-feedback">
                        Password must be at least 6 characters.
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="col-md-6">
                    <label for="confirm_password" class="form-label">
                        Confirm Password <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <input type="password"
                               class="form-control"
                               id="confirm_password"
                               name="confirm_password"
                               placeholder="Re-enter password"
                               minlength="6"
                               required>
                        <button class="btn btn-outline-secondary"
                                type="button"
                                onclick="togglePassword('confirm_password', this)">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <div class="invalid-feedback" id="passwordMismatch">
                        Passwords do not match.
                    </div>
                </div>

                <!-- Role -->
                <div class="col-12">
                    <label for="role" class="form-label">
                        User Role <span class="text-danger">*</span>
                    </label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="">-- Select Role --</option>
                        <option value="student">Student</option>
                        <option value="librarian">Librarian</option>
                        <?php if ($_SESSION['role'] === 'admin'): ?>
                        <option value="admin">Admin</option>
                        <?php endif; ?>
                    </select>
                    <div class="invalid-feedback">
                        Please select a user role.
                    </div>

                    <!-- Role Descriptions -->
                    <div class="mt-3 p-3 bg-light rounded">
                        <h6 class="text-muted mb-2">
                            <i class="bi bi-info-circle me-1"></i>Role Permissions
                        </h6>
                        <div class="row g-2">
                            <div class="col-md-4">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-person-badge text-primary me-2 mt-1"></i>
                                    <div>
                                        <strong>Student</strong>
                                        <small class="d-block text-muted">Can browse and read books</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-people text-success me-2 mt-1"></i>
                                    <div>
                                        <strong>Librarian</strong>
                                        <small class="d-block text-muted">Can manage books and users</small>
                                    </div>
                                </div>
                            </div>
                            <?php if ($_SESSION['role'] === 'admin'): ?>
                            <div class="col-md-4">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-shield-check text-danger me-2 mt-1"></i>
                                    <div>
                                        <strong>Admin</strong>
                                        <small class="d-block text-muted">Full system access</small>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <!-- Action Buttons -->
            <div class="d-flex gap-2 justify-content-end">
                <a href="<?= BASE_URL ?>?route=users" class="btn btn-outline-secondary btn-lg">
                    <i class="bi bi-x-circle me-1"></i>
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-check-circle me-1"></i>
                    Create User
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Toggle password visibility
function togglePassword(fieldId, button) {
    const field = document.getElementById(fieldId);
    const icon = button.querySelector('i');

    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
}

// Form validation
(function () {
    'use strict'

    const form = document.querySelector('.needs-validation');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');

    // Real-time password match validation
    function checkPasswordMatch() {
        if (confirmPassword.value && password.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity('Passwords do not match');
            return false;
        } else {
            confirmPassword.setCustomValidity('');
            return true;
        }
    }

    password.addEventListener('input', checkPasswordMatch);
    confirmPassword.addEventListener('input', checkPasswordMatch);

    // Form submit validation
    form.addEventListener('submit', function (event) {
        // Check password match
        if (!checkPasswordMatch()) {
            event.preventDefault();
            event.stopPropagation();
        }

        // Check form validity
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }

        form.classList.add('was-validated');
    }, false);
})();
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
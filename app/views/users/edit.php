<?php

require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/sidebar.php';
?>

<style>
.form-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    border: 1px solid #f0f0f0;
    max-width: 900px;
    margin: 0 auto;
}

.form-header {
    background: linear-gradient(135deg, #6366f1 0%, #3b82f6 100%);
    border-radius: 12px;
    padding: 1.5rem;
    color: white;
    margin-bottom: 2rem;
    text-align: center;
}

.form-group-modern label {
    font-size: 0.875rem;
    font-weight: 600;
    color: #4a5568;
    margin-bottom: 0.5rem;
}

.form-group-modern input,
.form-group-modern select {
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    padding: 0.75rem 1rem;
    transition: all 0.2s ease;
}

.form-group-modern input:focus,
.form-group-modern select:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.12);
}

.info-card {
    background: #f8f9fa;
    border-radius: 12px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.04);
    border: 1px solid #e2e8f0;
}

.breadcrumb {
    background: none;
    padding: 0;
    margin-bottom: 0.75rem;
}

</style>

<!-- Back Button -->
<div class="mb-3">
    <a href="<?= BASE_URL ?>?route=users" class="btn btn-soft-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back to Users
    </a>
</div>
<div class="form-card">
    <!-- Header -->
    <div class="form-header">
        <h3 class="mb-0 text-white">
            <i class="bi bi-pencil-square me-2"></i>
            Edit User
        </h3>
        <p class="mb-0 mt-2 text-white" style="opacity:0.9;">Update user information and account details</p>
    </div>

    <!-- Edit User Form -->
    <form method="POST" action="<?= BASE_URL ?>?route=users/edit&id=<?= $user['id'] ?>">
        <h5 class="mb-3">
            <i class="bi bi-info-circle text-primary me-2"></i>
            Basic Information
        </h5>

        <div class="row g-3 mb-4">
            <div class="col-md-6 form-group-modern">
                <label for="name">
                    <i class="bi bi-person me-1"></i>Full Name *
                </label>
                <input type="text"
                       class="form-control"
                       id="name"
                       name="name"
                       value="<?= htmlspecialchars($user['name']) ?>"
                       required>
            </div>

            <div class="col-md-6 form-group-modern">
                <label for="email">
                    <i class="bi bi-envelope me-1"></i>Email Address *
                </label>
                <input type="email"
                       class="form-control"
                       id="email"
                       name="email"
                       value="<?= htmlspecialchars($user['email']) ?>"
                       required>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-6 form-group-modern">
                <label for="role">
                    <i class="bi bi-person-badge me-1"></i>User Role *
                </label>
                <select class="form-control" id="role" name="role" required>
                    <option value="student" <?= $user['role'] === 'student' ? 'selected' : '' ?>>Student</option>
                    <option value="librarian" <?= $user['role'] === 'librarian' ? 'selected' : '' ?>>Librarian</option>
                    <?php if ($_SESSION['role'] === 'admin'): ?>
                        <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                    <?php endif; ?>
                </select>
            </div>
        </div>

        <hr class="my-4">

        <h5 class="mb-3">
            <i class="bi bi-lock text-primary me-2"></i>
            Change Password <span class="text-muted" style="font-size:0.9rem;">(optional)</span>
        </h5>
        <p class="text-muted small mb-3">Leave blank to keep current password</p>

        <div class="row g-3 mb-4">
            <div class="col-md-6 form-group-modern">
                <label for="new_password">
                    <i class="bi bi-key me-1"></i>New Password
                </label>
                <input type="password"
                       class="form-control"
                       id="new_password"
                       name="new_password"
                       placeholder="Leave blank to keep current"
                       minlength="6">
                <small class="text-muted">Minimum 6 characters</small>
            </div>

            <div class="col-md-6 form-group-modern">
                <label for="confirm_password">
                    <i class="bi bi-key me-1"></i>Confirm New Password
                </label>
                <input type="password"
                       class="form-control"
                       id="confirm_password"
                       name="confirm_password"
                       placeholder="Re-enter new password"
                       minlength="6">
            </div>
        </div>

        <hr class="my-4">

        <!-- Action Buttons -->
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-soft-primary btn-lg">
                <i class="bi bi-save me-2"></i> Update User
            </button>
            <a href="<?= BASE_URL ?>?route=users" class="btn btn-soft-secondary btn-lg">
                <i class="bi bi-x-circle me-2"></i> Cancel
            </a>
        </div>
    </form>

    <!-- User Info Card -->
    <div class="info-card mt-4 p-4">
        <h6 class="mb-3"><i class="bi bi-person-lines-fill me-2"></i>Account Information</h6>
        <div class="row">
            <div class="col-md-6 mb-2">
                <small class="text-muted">User ID:</small><br>
                <strong><?= $user['id'] ?></strong>
            </div>
            <div class="col-md-6 mb-2">
                <small class="text-muted">Member Since:</small><br>
                <strong><?= date('F d, Y', strtotime($user['created_at'])) ?></strong>
            </div>
        </div>
    </div>
</div>

<script>
// Password match validation
document.getElementById('confirm_password').addEventListener('input', function() {
    const newPassword = document.getElementById('new_password').value;
    const confirmPassword = this.value;

    if (newPassword && confirmPassword && newPassword !== confirmPassword) {
        this.setCustomValidity('Passwords do not match');
    } else {
        this.setCustomValidity('');
    }
});

document.getElementById('new_password').addEventListener('input', function() {
    const confirmPassword = document.getElementById('confirm_password');
    if (confirmPassword.value) {
        confirmPassword.dispatchEvent(new Event('input'));
    }
});
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
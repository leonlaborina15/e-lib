<?php

require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/sidebar.php';
?>

<style>

:root {
    --primary: #23272f;
    --card-bg: #fff;
    --soft-bg: #f6f8fa;
    --border: #e6e8ec;
    --muted-bg: #f3f4f6;
    --secondary: #7b8191;
}
    .profile-header {
    background: linear-gradient(90deg, #23272f 0%, #444851 100%);
    border-radius: 16px;
    padding: 2rem;
    color: #fff;
    margin-bottom: 2rem;
    box-shadow: 0 4px 12px rgba(30, 30, 30, 0.11);
}

.profile-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: #fff;
    color: var(--text);
    font-size: 2.5rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.profile-card {
    background: #fff;
    border-radius: 16px;
    padding: 2rem;
    border: 1px solid #f0f0f0;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    margin-bottom: 1.5rem;
    color: var(--text);
}

.form-group-modern label {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text);
    margin-bottom: 0.5rem;
}

.form-group-modern input {
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    padding: 0.75rem 1rem;
    transition: all 0.2s ease;
    background: #fff;
    color: var(--text);
}

.form-group-modern input:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    background: #fff;
}

.form-group-modern input:disabled {
    background: #f8f9fa;
    color: #718096;
}

.stat-list {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

.stat-card.stat-horizontal {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.25rem 2rem;
    background: #f6f8fa;
    border-radius: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    border: none;
    min-width: 270px;
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 16px;
    background: #f3f4f6;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
}

.stat-icon i {
    color: var(--text)   !important; /* Force dark gray/black icon */
}

.stat-number {
    font-size: 1.7rem;
    font-weight: 600;
    color: var(--text);
    margin-bottom: 2px;
}

.stat-label {
    font-size: 1rem;
    color: #444851;
}

.password-toggle {
    position: absolute;
    right: 12px;
    top: 38px;
    cursor: pointer;
    color: #718096;
}

.password-toggle:hover {
    color: var(--text);
}

.btn-soft-primary, .btn-soft-secondary, .btn-soft-warning {
    background: #23272f;
    color: #fff;
    border: none;
    border-radius: 8px;
    transition: background 0.2s, color 0.2s;
}
.btn-soft-primary:hover, .btn-soft-secondary:hover, .btn-soft-warning:hover {
    background: #444851;
    color: #fff;
}

.badge {
    background: #444851;
    color: #fff;
    font-size: 0.875rem;
}
hr {
    border-color: #f0f0f0;
}
.text-muted {
    color: #888 !important;
}
.bi {
    color: var(--text)  !important;
}
.profile-header .bi {
    color: #fff !important; /* or rgba(255,255,255,0.8) for softer */
}
</style>


<!-- Profile Header -->
<div class="profile-header">
    <div class="d-flex align-items-center gap-3">
        <div class="profile-avatar" style="overflow: hidden;">
            <?php if (!empty($user['photo'])): ?>
                <img src="<?= BASE_URL . 'uploads/photos/' . htmlspecialchars($user['photo']) ?>"
                    alt="Profile Photo"
                    style="width:100px; height:100px; border-radius:50%; object-fit:cover;">
            <?php else: ?>
                <?= strtoupper(substr($user['name'], 0, 1)) ?>
            <?php endif; ?>
        </div>
        <div>
            <h2 class="mb-1 text-white"><?= htmlspecialchars($user['name']) ?></h2>
            <p class="mb-0 opacity-75 text-white">
                <i class="bi bi-envelope me-1"></i>
                <?= htmlspecialchars($user['email']) ?>
            </p>
            <span class="badge mt-2 text-white" style="background: rgba(255,255,255,0.2); font-size: 0.875rem;">
                <i class="bi bi-shield-check me-1"></i>
                <?= ucfirst($user['role']) ?>
            </span>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Edit Profile Form -->
    <div class="col-lg-8">
        <div class="profile-card">
            <h5 class="mb-4">
                <i class="bi bi-person-circle text-primary me-2"></i>
                Edit Profile Information
            </h5>

            <form method="POST" id="profileForm" enctype="multipart/form-data">
                <!-- Name & Email -->
                <div class="row g-3 mb-3">
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

                <!-- Role & Member Since (Read-only) -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6 form-group-modern">
                        <label>
                            <i class="bi bi-shield me-1"></i>Account Role
                        </label>
                        <input type="text"
                            class="form-control"
                            value="<?= ucfirst($user['role']) ?>"
                            disabled>
                        <small class="text-muted">Your role cannot be changed</small>
                    </div>

                    <div class="col-md-6 form-group-modern">
                        <label>
                            <i class="bi bi-calendar-check me-1"></i>Member Since
                        </label>
                        <input type="text"
                            class="form-control"
                            value="<?= date('F d, Y', strtotime($user['created_at'])) ?>"
                            disabled>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Change Password Section -->
                <h5 class="mb-3">
                    <i class="bi bi-lock text-warning me-2"></i>
                    Change Password (Optional)
                </h5>


                <div class="row g-3">
                    <div class="col-12 form-group-modern position-relative">
                        <label for="current_password">
                            <i class="bi bi-key me-1"></i>Current Password
                        </label>
                        <input type="password"
                            class="form-control"
                            id="current_password"
                            name="current_password"
                            placeholder="Enter your current password">
                        <i class="bi bi-eye password-toggle" onclick="togglePassword('current_password')"></i>
                    </div>

                    <div class="col-md-6 form-group-modern position-relative">
                        <label for="new_password">
                            <i class="bi bi-shield-lock me-1"></i>New Password
                        </label>
                        <input type="password"
                            class="form-control"
                            id="new_password"
                            name="new_password"
                            placeholder="Enter new password"
                            minlength="6">
                        <i class="bi bi-eye password-toggle" onclick="togglePassword('new_password')"></i>
                        <small class="text-muted">Minimum 6 characters</small>
                    </div>

                    <div class="col-md-6 form-group-modern position-relative">
                        <label for="confirm_password">
                            <i class="bi bi-shield-check me-1"></i>Confirm New Password
                        </label>
                        <input type="password"
                            class="form-control"
                            id="confirm_password"
                            name="confirm_password"
                            placeholder="Confirm new password">
                        <i class="bi bi-eye password-toggle" onclick="togglePassword('confirm_password')"></i>
                        <div id="passwordMatchMessage" class="mt-1"></div>
                    </div>
                </div>

                <hr class="my-4">
                <div class="row g-3 mb-3">
                    <div class="col-md-6 form-group-modern">
                        <label for="photo">
                            <i class="bi bi-image me-1"></i>Profile Photo
                        </label>
                        <input type="file"
                            class="form-control"
                            id="photo"
                            name="photo"
                            accept="image/*">
                        <small class="text-muted">Upload a photo (JPG, PNG, GIF)</small>
                    </div>
                    <?php if (!empty($user['photo'])): ?>
                        <div class="col-md-6">
                            <label>Current Photo</label><br>
                            <img src="<?= BASE_URL . 'uploads/photos/' . htmlspecialchars($user['photo']) ?>" alt="Profile Photo" style="width:80px; height:80px; border-radius:50%; object-fit:cover;">
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Action Buttons -->
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-soft-primary btn-lg">
                        <i class="bi bi-save me-2"></i> Update Profile
                    </button>
                    <a href="<?= BASE_URL ?>?route=dashboard" class="btn btn-soft-secondary btn-lg">
                        <i class="bi bi-arrow-left me-2"></i> Back to Dashboard
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistics Sidebar -->
    <div class="col-lg-4">
        <!-- User Stats -->
        <div class="profile-card">
            <h5 class="mb-3">
                <i class="bi bi-graph-up text-success me-2"></i>
                My Statistics
            </h5>
            <div class="stat-list">
                <div class="stat-card stat-horizontal">
                    <div class="stat-icon">
                        <i class="bi bi-book"></i>
                    </div>
                    <div>
                        <div class="stat-number"><?= $total_books_count ?? 0 ?></div>
                        <div class="stat-label">Total Books</div>
                    </div>
                </div>
                <div class="stat-card stat-horizontal">
                    <div class="stat-icon">
                        <i class="bi bi-heart-fill"></i>
                    </div>
                    <div>
                        <div class="stat-number"><?= $favorites_count ?? 0 ?></div>
                        <div class="stat-label">Favorite Books</div>
                    </div>
                </div>
                <div class="stat-card stat-horizontal">
                    <div class="stat-icon">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <div>
                        <div class="stat-number"><?= $history_count ?? 0 ?></div>
                        <div class="stat-label">Books Read</div>
                    </div>
                </div>
                <div class="stat-card stat-horizontal">
                    <div class="stat-icon">
                        <i class="bi bi-activity"></i>
                    </div>
                    <div>
                        <div class="stat-number"><?= $activity_count ?? 0 ?></div>
                        <div class="stat-label">Recent Activities</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="profile-card">
            <h6 class="mb-3 text-muted">Quick Links</h6>
            <div class="d-grid gap-2">
                <a href="<?= BASE_URL ?>?route=books" class="btn btn-soft-secondary btn-sm">
                    <i class="bi bi-book me-1"></i> Browse Books
                </a>
                <?php if ($user['role'] === 'admin' || $user['role'] === 'librarian'): ?>
                    <a href="<?= BASE_URL ?>?route=books/create" class="btn btn-soft-warning btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Add Book
                    </a>
                    <a href="<?= BASE_URL ?>?route=users" class="btn btn-soft-secondary btn-sm">
                        <i class="bi bi-people me-1"></i> Manage Users
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = field.nextElementSibling;

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

document.getElementById('confirm_password').addEventListener('input', function() {
    const newPassword = document.getElementById('new_password').value;
    const confirmPassword = this.value;
    const messageDiv = document.getElementById('passwordMatchMessage');

    if (confirmPassword === '') {
        messageDiv.innerHTML = '';
        this.setCustomValidity('');
    } else if (newPassword !== confirmPassword) {
        messageDiv.innerHTML = '<small class="text-danger"><i class="bi bi-x-circle me-1"></i>Passwords do not match</small>';
        this.setCustomValidity('Passwords do not match');
    } else {
        messageDiv.innerHTML = '<small class="text-success"><i class="bi bi-check-circle me-1"></i>Passwords match</small>';
        this.setCustomValidity('');
    }
});

document.getElementById('new_password').addEventListener('input', function() {
    const confirmPassword = document.getElementById('confirm_password');
    if (confirmPassword.value !== '') {
        confirmPassword.dispatchEvent(new Event('input'));
    }
});
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
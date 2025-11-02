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
    min-width: 100px;
    border-radius: 50%;
    background: #fff;
    color: var(--text);
    font-size: 2.5rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    overflow: hidden;
    position: relative;
}

.profile-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
}

.current-photo-preview {
    width: 80px;
    height: 80px;
    min-width: 80px;
    border-radius: 50%;
    overflow: hidden;
    display: inline-block;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border: 3px solid #f0f0f0;
}

.current-photo-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
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
    display: block;
}

.form-group-modern input {
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    padding: 0.75rem 1rem;
    transition: all 0.2s ease;
    background: #fff;
    color: var(--text);
    width: 100%;
}

.form-group-modern input:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    background: #fff;
    outline: none;
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
    flex-shrink: 0;
}

.stat-icon i {
    color: var(--text) !important;
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
    z-index: 10;
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
    color: var(--text) !important;
}

.profile-header .bi {
    color: #fff !important;
}

/* Mobile Responsive Styles */
@media (max-width: 992px) {
    .profile-header {
        padding: 1.5rem;
    }

    .profile-header .d-flex {
        flex-direction: column;
        text-align: center;
        align-items: center !important;
    }

    .profile-avatar {
        width: 80px;
        height: 80px;
        min-width: 80px;
        font-size: 2rem;
        margin-bottom: 1rem;
    }

    .profile-card {
        padding: 1.5rem;
    }

    .stat-card.stat-horizontal {
        padding: 1rem 1.5rem;
        min-width: 100%;
    }

    .stat-icon {
        width: 45px;
        height: 45px;
        font-size: 1.5rem;
    }

    .stat-number {
        font-size: 1.5rem;
    }

    .stat-label {
        font-size: 0.9rem;
    }

    .current-photo-preview {
        width: 70px;
        height: 70px;
        min-width: 70px;
    }
}

@media (max-width: 768px) {
    .profile-header {
        padding: 1.25rem;
        border-radius: 12px;
    }

    .profile-header h2 {
        font-size: 1.5rem;
    }

    .profile-avatar {
        width: 70px;
        height: 70px;
        min-width: 70px;
        font-size: 1.8rem;
    }

    .profile-card {
        padding: 1.25rem;
        border-radius: 12px;
    }

    .profile-card h5 {
        font-size: 1.1rem;
    }

    .form-group-modern label {
        font-size: 0.85rem;
    }

    .form-group-modern input {
        padding: 0.65rem 0.85rem;
        font-size: 0.9rem;
    }

    .password-toggle {
        top: 36px;
        right: 10px;
        font-size: 1.1rem;
    }

    .stat-card.stat-horizontal {
        padding: 0.9rem 1.25rem;
        gap: 0.75rem;
    }

    .stat-icon {
        width: 40px;
        height: 40px;
        font-size: 1.3rem;
    }

    .stat-number {
        font-size: 1.3rem;
    }

    .stat-label {
        font-size: 0.85rem;
    }

    .btn-lg {
        padding: 0.65rem 1rem;
        font-size: 1rem;
    }

    .row.g-3 {
        gap: 1rem !important;
    }

    .current-photo-preview {
        width: 65px;
        height: 65px;
        min-width: 65px;
    }
}

@media (max-width: 576px) {
    .profile-header {
        padding: 1rem;
        margin-bottom: 1.5rem;
    }

    .profile-header h2 {
        font-size: 1.25rem;
    }

    .profile-header p {
        font-size: 0.85rem;
    }

    .profile-avatar {
        width: 60px;
        height: 60px;
        min-width: 60px;
        font-size: 1.5rem;
    }

    .profile-card {
        padding: 1rem;
    }

    .profile-card h5 {
        font-size: 1rem;
        margin-bottom: 1rem !important;
    }

    .form-group-modern label {
        font-size: 0.8rem;
    }

    .form-group-modern input {
        padding: 0.6rem 0.75rem;
        font-size: 0.85rem;
    }

    .form-group-modern small {
        font-size: 0.75rem;
    }

    .password-toggle {
        top: 35px;
        right: 8px;
        font-size: 1rem;
    }

    .stat-card.stat-horizontal {
        padding: 0.75rem 1rem;
        gap: 0.6rem;
        border-radius: 12px;
    }

    .stat-icon {
        width: 35px;
        height: 35px;
        font-size: 1.1rem;
    }

    .stat-number {
        font-size: 1.1rem;
    }

    .stat-label {
        font-size: 0.75rem;
    }

    .btn-lg {
        padding: 0.6rem 0.85rem;
        font-size: 0.9rem;
    }

    .btn-sm {
        padding: 0.45rem 0.75rem;
        font-size: 0.85rem;
    }

    hr {
        margin: 1.5rem 0 !important;
    }

    .badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }

    .current-photo-preview {
        width: 60px;
        height: 60px;
        min-width: 60px;
        margin-top: 0.5rem;
    }

    /* Make password fields stack better on mobile */
    .position-relative {
        position: relative !important;
    }
}

/* Extra small devices */
@media (max-width: 400px) {
    .profile-header {
        padding: 0.85rem;
    }

    .profile-avatar {
        width: 55px;
        height: 55px;
        min-width: 55px;
        font-size: 1.3rem;
    }

    .profile-card {
        padding: 0.85rem;
    }

    .stat-card.stat-horizontal {
        padding: 0.65rem 0.85rem;
        gap: 0.5rem;
    }

    .stat-icon {
        width: 32px;
        height: 32px;
        font-size: 1rem;
    }

    .stat-number {
        font-size: 1rem;
    }

    .stat-label {
        font-size: 0.7rem;
    }

    .current-photo-preview {
        width: 55px;
        height: 55px;
        min-width: 55px;
    }
}
</style>


<!-- Profile Header -->
<div class="profile-header">
    <div class="d-flex align-items-center gap-3">
        <div class="profile-avatar">
            <?php if (!empty($user['photo'])): ?>
                <img src="<?= BASE_URL . 'uploads/photos/' . htmlspecialchars($user['photo']) ?>"
                    alt="Profile Photo">
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

                <!-- Profile Photo Section -->
                <h5 class="mb-3">
                    <i class="bi bi-image text-info me-2"></i>
                    Profile Photo
                </h5>

                <div class="row g-3 mb-3">
                    <div class="col-md-6 form-group-modern">
                        <label for="photo">
                            <i class="bi bi-upload me-1"></i>Upload New Photo
                        </label>
                        <input type="file"
                            class="form-control"
                            id="photo"
                            name="photo"
                            accept="image/*"
                            onchange="previewImage(this)">
                        <small class="text-muted">Supported: JPG, PNG, GIF (Max 5MB)</small>
                    </div>
                    <div class="col-md-6">
                        <?php if (!empty($user['photo'])): ?>
                            <label>Current Photo</label><br>
                            <div class="current-photo-preview">
                                <img src="<?= BASE_URL . 'uploads/photos/' . htmlspecialchars($user['photo']) ?>"
                                     alt="Profile Photo"
                                     id="currentPhotoPreview">
                            </div>
                        <?php else: ?>
                            <label>No photo uploaded</label><br>
                            <div class="current-photo-preview" style="background: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-person-circle" style="font-size: 2rem; color: #ccc;"></i>
                            </div>
                        <?php endif; ?>
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

function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            const preview = document.getElementById('currentPhotoPreview');
            if (preview) {
                preview.src = e.target.result;
            }
        }

        reader.readAsDataURL(input.files[0]);
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
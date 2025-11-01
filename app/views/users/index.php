<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<style>

body {
    background: #f5f6fa;
}
:root {
    --primary: #23272f;
    --secondary: #7b8191;
    --muted-bg: #f3f4f6;
    --card-bg: #fff;
    --soft-bg: #f6f8fa;
    --border: #e6e8ec;
    --accent: #8b94ab;
}

.card {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 4px 24px rgba(30,30,30,0.09);
    border: none;
}

.card-body {
    padding: 2rem;
}

.table {
    background: transparent;
    border-radius: 12px;
    margin-bottom: 0;
}

.table th, .table td {
    background: transparent;
    vertical-align: middle;
    font-size: 1rem;
    border: none;
}

.table thead th {
    font-weight: 600;
    color: #23272f;
    letter-spacing: 0.03em;
    background: #f6f8fa;
    border-bottom: 2px solid #e6e8ec;
}

.table-hover tbody tr:hover {
    background: #f3f4f6;
}

.table tbody tr {
    transition: background 0.18s;
}

.avatar.avatar-sm {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #e6e8ec;
    font-weight: 700;
    color: #23272f;
    display: flex;
    align-items: center;
    justify-content: center;
}

.role-badge {
    display: inline-block;
    padding: 0.35em 0.85em;
    font-size: 0.73rem;
    font-weight: 700;
    line-height: 1;
    text-align: center;
    white-space: nowrap;
    border-radius: 6px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.role-badge.student {
    background: #6c757d;
    color: #fff;
}
.role-badge.librarian {
    background: #495057;
    color: #fff;
}
.role-badge.admin {
    background: #212529;
    color: #fff;
}
.role-badge:hover {
    opacity: 0.85;
}

.badge.bg-info {
    background: #e6f4fa;
    color: #2563eb;
    border-radius: 8px;
    font-size: 0.69rem;
    padding: 0.20em 0.7em;
    font-weight: 600;
    border: none;
}

.btn-group .btn {
    border-radius: 8px !important;
    border: 1px solid #e6e8ec !important;
    background: #fff !important;
    color: #23272f !important;
    box-shadow: none !important;
    padding: 0.35em 0.8em;
    margin: 0 2px;
    transition: border 0.2s, color 0.2s;
}

.btn-outline-primary {
    border-color: #7b8191 !important;
    color: #7b8191 !important;
}
.btn-outline-primary:hover {
    background: #f3f4f6 !important;
    color: #23272f !important;
}

.btn-outline-danger {
    border-color: #ff6868 !important;
    color: #ff6868 !important;
}
.btn-outline-danger:hover {
    background: #ffebeb !important;
    color: #d90429 !important;
}

.btn-primary {
    background: #23272f !important;
    color: #fff !important;
    border-radius: 8px !important;
    border: none !important;
    font-weight: 500;
    box-shadow: 0 2px 8px rgba(37,99,235,0.08);
    transition: background 0.2s;
}
.btn-primary:hover {
    background: #495057 !important;
    color: #fff !important;
}

.empty-state i {
    color: #cbd5e0 !important;
}
.empty-state h3 {
    font-weight: 700;
    color: #23272f;
}
.empty-state .btn-primary {
    margin-top: 1rem;
}

.table-responsive {
    border-radius: 12px;
    overflow-x: auto;
}

.table-light {
    background: #f6f8fa;
}

.mt-4.pt-3.border-top {
    border-top: 1px solid #e6e8ec !important;
}

.row.text-center.g-3 .col-6 .p-3 {
    background: none;
    border-radius: 8px;
}

.row.text-center.g-3 i {
    font-size: 2rem;
    color: #8b94ab !important;
    margin-bottom: 0.5rem;
}

.row.text-center.g-3 h4 {
    font-size: 1.35rem;
    font-weight: 700;
    margin: 0.3em 0;
    color: #23272f;
}

.row.text-center.g-3 small {
    color: #8b94ab;
}
</style>

<!-- Manage Users Page -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Manage Users</h2>
        <p class="text-muted mb-0">View and manage all system users</p>
    </div>
    <a href="<?= BASE_URL ?>?route=users/create" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Add New User
    </a>
</div>

<!-- Users Table -->
<div class="card shadow-sm">
    <div class="card-body">
        <?php if (empty($users)): ?>
            <div class="empty-state text-center py-5">
                <i class="bi bi-people" style="font-size: 3rem;"></i>
                <h3 class="mt-3">No users found</h3>
                <p class="text-muted">Start by adding your first user.</p>
                <a href="<?= BASE_URL ?>?route=users/create" class="btn btn-primary mt-2">
                    <i class="bi bi-plus"></i> Add First User
                </a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="60">#</th>
                            <th>NAME</th>
                            <th>EMAIL</th>
                            <th width="130" class="text-center">ROLE</th>
                            <th width="150">JOINED</th>
                            <th width="120" class="text-center">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $index => $user): ?>
                            <tr>
                                <td class="text-muted"><?= $index + 1 ?></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                    <div class="avatar avatar-sm" style="overflow: hidden;">
                                        <?php if (!empty($user['photo'])): ?>
                                            <img src="<?= BASE_URL . 'uploads/photos/' . htmlspecialchars($user['photo']) ?>"
                                                alt="Profile Photo"
                                                style="width:32px; height:32px; border-radius:50%; object-fit:cover;">
                                        <?php else: ?>
                                            <?= strtoupper(substr($user['name'], 0, 1)) ?>
                                        <?php endif; ?>
                                    </div>
                                        <strong><?= htmlspecialchars($user['name']) ?></strong>
                                        <?php if ($user['id'] == $_SESSION['user_id']): ?>
                                            <span class="badge bg-info" style="font-size: 0.65rem;">You</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <i class="bi bi-envelope text-muted me-1"></i>
                                    <?= htmlspecialchars($user['email']) ?>
                                </td>
                                <td class="text-center">
                                    <span class="role-badge <?= strtolower($user['role']) ?>">
                                        <?= strtoupper($user['role']) ?>
                                    </span>
                                </td>
                                <td>
                                    <i class="bi bi-calendar3 text-muted me-1"></i>
                                    <small class="text-muted">
                                        <?= date('M d, Y', strtotime($user['created_at'])) ?>
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm d-flex justify-content-center" role="group">
                                        <a href="<?= BASE_URL ?>?route=users/edit&id=<?= $user['id'] ?>"
                                           class="btn btn-outline-primary"
                                           title="Edit User">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <?php if ($user['id'] != $_SESSION['user_id'] && $_SESSION['role'] === 'admin'): ?>
                                            <a href="<?= BASE_URL ?>?route=users/delete&id=<?= $user['id'] ?>"
                                               class="btn btn-outline-danger"
                                               onclick="return confirm('⚠️ Are you sure you want to delete <?= htmlspecialchars($user['name']) ?>?\n\nThis action cannot be undone!')"
                                               title="Delete User">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Stats Footer -->
            <div class="mt-4 pt-3 border-top">
                <div class="row text-center g-3">
                    <div class="col-6 col-md-3">
                        <div class="p-3">
                            <i class="bi bi-people-fill"></i>
                            <h4 class="mb-0 mt-2"><?= count($users) ?></h4>
                            <small class="text-muted">Total Users</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="p-3">
                            <i class="bi bi-person-badge-fill"></i>
                            <h4 class="mb-0 mt-2">
                                <?= count(array_filter($users, fn($u) => strtolower($u['role']) === 'student')) ?>
                            </h4>
                            <small class="text-muted">Students</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="p-3">
                            <i class="bi bi-people-fill"></i>
                            <h4 class="mb-0 mt-2">
                                <?= count(array_filter($users, fn($u) => strtolower($u['role']) === 'librarian')) ?>
                            </h4>
                            <small class="text-muted">Librarians</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="p-3">
                            <i class="bi bi-shield-check-fill"></i>
                            <h4 class="mb-0 mt-2">
                                <?= count(array_filter($users, fn($u) => strtolower($u['role']) === 'admin')) ?>
                            </h4>
                            <small class="text-muted">Admins</small>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
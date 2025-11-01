<?php if (isset($_SESSION['user_id'])): ?>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 sidebar" id="mainSidebar">
            <div class="position-sticky">
                <!-- Close button for mobile -->
                <div class="d-lg-none text-end p-3">
                    <button class="btn btn-link text-dark" onclick="toggleSidebar()">
                        <i class="bi bi-x-lg" style="font-size: 1.5rem;"></i>
                    </button>
                </div>

                <!-- Brand -->
                <div class="text-center px-3 mb-4">
                    <div class="mb-3">
                        <!-- Your PNG logo here. Place logo.png in public/assets/ -->
                        <img src="<?= BASE_URL ?>assets/logo1.png" alt="Logo" style="max-width: 64px; max-height: 64px; margin-bottom: 0.5rem;">
                    </div>
                    <h4>My Library</h4>
                    <p class="text-muted mb-0" style="font-size: 0.875rem;">
                        <?= htmlspecialchars($_SESSION['name']) ?>
                    </p>
                </div>

                <!-- Navigation -->
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link <?= ($_GET['route'] ?? '') == 'dashboard' ? 'active' : '' ?>"
                           href="<?= BASE_URL ?>?route=dashboard">
                            <i class="bi bi-grid"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($_GET['route'] ?? '') == 'books' ? 'active' : '' ?>"
                           href="<?= BASE_URL ?>?route=books">
                            <i class="bi bi-book"></i>
                            <span>Browse Books</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= BASE_URL ?>?route=favorites"
                           class="nav-link <?= ($_GET['route'] ?? '') == 'favorites' ? 'active' : '' ?>">
                            <i class="bi bi-heart-fill"></i> My Favorites
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= BASE_URL ?>?route=history"
                           class="nav-link <?= ($_GET['route'] ?? '') == 'history' ? 'active' : '' ?>">
                            <i class="bi bi-clock-history"></i> Reading History
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= BASE_URL ?>?route=reviews"
                           class="nav-link <?= ($_GET['route'] ?? '') == 'reviews' ? 'active' : '' ?>">
                            <i class="bi bi-star-fill"></i> Reviews
                        </a>
                    </li>

                    <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'librarian'): ?>
                    <hr>
                    <li class="nav-item">
                        <small class="px-3 text-muted text-uppercase" style="font-size: 0.7rem; font-weight: 600; letter-spacing: 0.05em;">
                            Management
                        </small>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos($_GET['route'] ?? '', 'books/create') !== false ? 'active' : '' ?>"
                           href="<?= BASE_URL ?>?route=books/create">
                            <i class="bi bi-plus-circle"></i>
                            <span>Add Book</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($_GET['route'] ?? '') == 'users' ? 'active' : '' ?>"
                           href="<?= BASE_URL ?>?route=users">
                            <i class="bi bi-people"></i>
                            <span>Manage Users</span>
                        </a>
                    </li>
                    <?php endif; ?>

                    <?php if ($_SESSION['role'] === 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= ($_GET['route'] ?? '') == 'logs' ? 'active' : '' ?>"
                           href="<?= BASE_URL ?>?route=logs">
                            <i class="bi bi-list-check"></i>
                            <span>Activity Logs</span>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>

                <hr>

                <!-- User Menu -->
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link <?= ($_GET['route'] ?? '') == 'profile' ? 'active' : '' ?>"
                           href="<?= BASE_URL ?>?route=profile">
                            <i class="bi bi-person"></i>
                            <span>My Profile</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>?route=logout"
                           onclick="return confirm('Are you sure you want to logout?')">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>

                <!-- Theme Toggle -->
                <div class="text-center mt-4">
                    <span class="theme-toggle" onclick="toggleTheme()" title="Toggle Theme">
                        <i class="bi bi-moon" id="themeIcon"></i>
                    </span>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col-md-10 ms-sm-auto">
            <!-- Top Bar (Desktop Only) - FIXED BREAKPOINT -->
            <div class="d-none d-lg-flex justify-content-between align-items-center border-bottom" style="padding: 1.5rem 2rem 1rem 2rem;">
                <div>
                    <h1><?= $page_title ?? 'Dashboard' ?></h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="<?= BASE_URL ?>?route=dashboard">
                                    <i class="bi bi-house-door"></i> Home
                                </a>
                            </li>
                            <?php if (isset($page_title) && $page_title !== 'Dashboard'): ?>
                                <li class="breadcrumb-item active"><?= $page_title ?></li>
                            <?php endif; ?>
                        </ol>
                    </nav>
                </div>

                <!-- Clean User Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle d-flex align-items-center gap-2"
                            type="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">
                        <div class="avatar avatar-sm" style="overflow: hidden;">
                            <?php if (!empty($_SESSION['photo'])): ?>
                                <img src="<?= BASE_URL . 'uploads/photos/' . htmlspecialchars($_SESSION['photo']) ?>"
                                     alt="Profile Photo"
                                     style="width:32px; height:32px; border-radius:50%; object-fit:cover;">
                            <?php else: ?>
                                <?= strtoupper(substr($_SESSION['name'], 0, 1)) ?>
                            <?php endif; ?>
                        </div>
                        <span><?= htmlspecialchars($_SESSION['name']) ?></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow">
                        <li>
                            <a class="dropdown-item" href="<?= BASE_URL ?>?route=profile">
                                <i class="bi bi-person me-2"></i>My Profile
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger"
                               href="<?= BASE_URL ?>?route=logout"
                               onclick="return confirm('Are you sure you want to logout?')">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Mobile Page Title - FIXED BREAKPOINT -->
            <div class="d-lg-none p-3">
                <h2 class="mb-0"><?= $page_title ?? 'Dashboard' ?></h2>
            </div>

            <!-- Content Wrapper - FIXED ALIGNMENT -->
            <div class="p-3" style="padding: 1.5rem 2rem !important;">
                <!-- Alerts -->
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill"></i>
                        <div>
                            <strong>Success!</strong><br>
                            <?= $_SESSION['success'] ?>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <div>
                            <strong>Error!</strong><br>
                            <?= $_SESSION['error'] ?>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['warning'])): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        <div>
                            <strong>Warning!</strong><br>
                            <?= $_SESSION['warning'] ?>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['warning']); ?>
                <?php endif; ?>

                <!-- Page Content Goes Here -->
<?php endif; ?>

<script>
// Toggle sidebar for mobile
function toggleSidebar() {
    const sidebar = document.getElementById('mainSidebar');
    const overlay = document.querySelector('.sidebar-overlay');

    if (sidebar && overlay) {
        sidebar.classList.toggle('show');
        overlay.classList.toggle('show');
    }
}

// Close sidebar when clicking a link (mobile only)
document.addEventListener('DOMContentLoaded', function() {
    if (window.innerWidth < 992) {
        const sidebarLinks = document.querySelectorAll('#mainSidebar .nav-link');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', function() {
                toggleSidebar();
            });
        });
    }
});
</script>
<?php if (isset($_SESSION['user_id'])): ?>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 d-md-block sidebar collapse" id="sidebarMenu">
            <div class="position-sticky pt-3">
                <div class="text-center mb-4">
                    <h4 class="text-white fw-bold">
                        <i class="bi bi-book-fill"></i> D-Library
                    </h4>
                    <p class="text-white-50 small"><?= $_SESSION['role'] ?></p>
                </div>

                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>?route=dashboard">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>?route=books">
                            <i class="bi bi-book"></i> Books
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>?route=borrow">
                            <i class="bi bi-arrow-left-right"></i> Borrow Records
                        </a>
                    </li>

                    <?php if ($_SESSION['role'] === 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>?route=users">
                            <i class="bi bi-people"></i> Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>?route=books/create">
                            <i class="bi bi-plus-circle"></i> Add Book
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>?route=logs">
                            <i class="bi bi-clock-history"></i> Activity Logs
                        </a>
                    </li>
                    <?php endif; ?>

                    <li class="nav-item mt-auto">
                        <a class="nav-link" href="<?= BASE_URL ?>?route=logout">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </li>
                </ul>

                <div class="text-center mt-4">
                    <span class="theme-toggle" onclick="toggleTheme()">
                        <i class="bi bi-moon-stars" id="themeIcon"></i>
                    </span>
                </div>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-10 ms-sm-auto px-md-4">
            <!-- Top Navigation Bar -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><?= $page_title ?? 'Dashboard' ?></h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="me-3">
                        <i class="bi bi-person-circle"></i>
                        <span class="ms-2"><?= $_SESSION['name'] ?></span>
                    </div>
                </div>
            </div>

            <!-- Alert Messages -->
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
<?php endif; ?>
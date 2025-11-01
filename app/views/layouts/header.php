<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'E-Library' ?> - E-Library System</title>

    <!-- Local Bootstrap CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/bootstrap.min.css">
    <!-- Local Bootstrap Icons CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/bootstrap-icons.css">
    <!-- Your custom styles -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">

    <style>
        /* CRITICAL FIX: Override Bootstrap grid on tablet/mobile */
        @media (max-width: 991px) {
            /* Force sidebar to behave as overlay, not grid column */
            .sidebar.col-md-2 {
                position: fixed !important;
                top: 0;
                left: -280px;
                width: 280px !important;
                height: 100vh;
                z-index: 1050;
                transition: left 0.3s ease;
                background: white;
                overflow-y: auto;
                box-shadow: 2px 0 10px rgba(0,0,0,0.1);
                flex: none !important;
                max-width: none !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .sidebar.col-md-2.show {
                left: 0;
            }

            /* Force main content to full width */
            main.col-md-10 {
                position: relative !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
                flex: 0 0 100% !important;
                padding: 0 !important;
            }

            /* Overlay */
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5);
                z-index: 1040;
            }

            .sidebar-overlay.show {
                display: block;
            }

            /* Mobile header */
            .mobile-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 1rem 1.25rem;
                background: white;
                border-bottom: 1px solid #dee2e6;
                position: sticky;
                top: 0;
                z-index: 1030;
            }

            .hamburger-btn {
                background: none;
                border: none;
                font-size: 1.5rem;
                color: #333;
                cursor: pointer;
                padding: 0.5rem;
            }

            /* Override Bootstrap row/container behavior */
            .container-fluid > .row {
                margin-left: 0 !important;
                margin-right: 0 !important;
            }
        }

        /* Desktop - Clean layout */
        @media (min-width: 992px) {
            .mobile-header {
                display: none !important;
            }

            .sidebar-overlay {
                display: none !important;
            }

            /* Let style.css fixed positioning work */
            .sidebar.col-md-2 {
                position: fixed !important;
                flex: none !important;
                max-width: none !important;
            }

            /* Proper spacing for main content */
            main.col-md-10 {
                margin-left: var(--sidebar-width, 260px) !important;
                width: calc(100% - var(--sidebar-width, 260px)) !important;
                max-width: calc(100% - var(--sidebar-width, 260px)) !important;
                flex: 0 0 auto !important;
            }
        }

        /* Dark theme sidebar background fix */
        body.dark-theme .sidebar {
            background: var(--bg, #09090b);
        }
    </style>
</head>
<body>

<!-- Mobile Header with Hamburger and Logo -->
<?php if (isset($_SESSION['user_id'])): ?>
<div class="mobile-header d-lg-none">
    <button class="hamburger-btn" onclick="toggleSidebar()">
        <i class="bi bi-list"></i>
    </button>
    <div class="d-flex align-items-center justify-content-center" style="gap:0.5rem;">
        <img src="<?= BASE_URL ?>assets/logo1.png" alt="Logo" style="max-width: 34px; max-height: 34px;">
        <h5 class="mb-0" style="font-weight: bold;">My Library</h5>
    </div>
    <div style="width: 40px;"></div>
</div>

<!-- Sidebar Overlay for Mobile -->
<div class="sidebar-overlay" onclick="toggleSidebar()"></div>
<?php endif; ?>
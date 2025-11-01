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
        /* Mobile Sidebar Styles */
        @media (max-width: 767px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: -280px;
                width: 280px;
                height: 100vh;
                z-index: 1050;
                transition: left 0.3s ease;
                background: white;
                overflow-y: auto;
                box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            }

            .sidebar.show {
                left: 0;
            }

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

            main.col-md-10 {
                margin-left: 0 !important;
                width: 100% !important;
                padding: 0 !important;
            }
        }

        @media (min-width: 768px) {
            .mobile-header {
                display: none;
            }

            .sidebar-overlay {
                display: none !important;
            }
        }

        /* Ensure proper alignment on desktop */
        @media (min-width: 768px) {
            main.col-md-10 {
                padding: 0 !important;
            }
        }
    </style>
</head>
<body>

<!-- Mobile Header with Hamburger and Logo -->
<?php if (isset($_SESSION['user_id'])): ?>
<div class="mobile-header d-md-none">
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
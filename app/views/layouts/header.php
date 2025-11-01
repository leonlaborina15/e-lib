<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'E-Library' ?> - D-Library System</title>

    <!-- Local Bootstrap CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/bootstrap.min.css">
    <!-- Local Bootstrap Icons CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/bootstrap-icons.css">
    <!-- Your custom styles -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">

    <style>
        /* Smooth transitions for theme switching */
        body, .card, .sidebar, .mobile-header, main, .btn, .form-control, .modal-content {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

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
                transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                background: var(--bg);
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

            /* Overlay with animation */
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5);
                z-index: 1040;
                opacity: 0;
                transition: opacity 0.3s ease;
            }

            .sidebar-overlay.show {
                display: block;
                opacity: 1;
            }

            /* Mobile header with dark theme support */
            .mobile-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 1rem 1.25rem;
                background: var(--bg);
                border-bottom: 1px solid var(--border);
                position: sticky;
                top: 0;
                z-index: 1030;
                transition: background-color 0.3s ease, border-color 0.3s ease;
            }

            .hamburger-btn {
                background: none;
                border: none;
                font-size: 1.5rem;
                color: var(--text);
                cursor: pointer;
                padding: 0.5rem;
                transition: transform 0.2s ease;
            }

            .hamburger-btn:active {
                transform: scale(0.95);
            }

            .mobile-header h5 {
                color: var(--text);
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

        /* Page Load Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Apply animations to content */
        main > * {
            animation: fadeInUp 0.5s ease-out;
        }

        .card {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Stagger animation for multiple cards */
        .card:nth-child(1) { animation-delay: 0.1s; }
        .card:nth-child(2) { animation-delay: 0.2s; }
        .card:nth-child(3) { animation-delay: 0.3s; }
        .card:nth-child(4) { animation-delay: 0.4s; }

        /* Smooth hover effects */
        .card, .btn, .book-card, .stat-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card:hover {
            transform: translateY(-4px);
        }

        .btn {
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn:active::before {
            width: 300px;
            height: 300px;
        }

        /* Loading skeleton for images */
        .skeleton {
            background: linear-gradient(90deg, var(--bg-muted) 25%, var(--bg-subtle) 50%, var(--bg-muted) 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* Dark theme sidebar background fix */
        body.dark-theme .sidebar {
            background: var(--bg, #09090b);
        }

        body.dark-theme .mobile-header {
            background: var(--bg);
            border-bottom-color: var(--border);
        }

        /* Scroll animations */
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert {
            animation: slideDown 0.4s ease-out;
        }
    </style>
</head>
<body>

<!-- Mobile Header with Hamburger and Logo -->
<?php if (isset($_SESSION['user_id'])): ?>
<div class="mobile-header d-lg-none">
    <button class="hamburger-btn" onclick="toggleSidebar()" aria-label="Toggle Menu">
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
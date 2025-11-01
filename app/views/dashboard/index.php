<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/sidebar.php';
?>

<style>
:root {
    --primary: #23272f;
    --secondary: #7b8191;
    --muted-bg: #f3f4f6;
    --card-bg: #fff;
    --soft-bg: #f6f8fa;
    --border: #e6e8ec;
    --accent: #8b94ab;
}

/* Center main content on mobile */
@media (max-width: 600px) {
    body {
        background: var(--muted-bg);
    }
    .dashboard-content, .container, .row.g-3 {
        max-width: 400px;
        margin: 0 auto !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
        display: block !important;
    }
    .mb-4, .dashboard-header, h2, .text-muted {
        text-align: center !important;
    }
    .stats-grid, .section-card, .reading-history-card, .book-mini-card, .quick-actions {
        margin-left: auto !important;
        margin-right: auto !important;
        width: 100%;
        max-width: 370px;
    }
    .stat-card {
        justify-content: center;
        text-align: center;
        flex-direction: row;
        padding: 1rem 1rem;
        min-height: 75px;
        gap: 0.75rem;
        max-width: 370px;
    }
    .stat-info {
        align-items: center;
        text-align: center;
    }
    .stat-icon {
        width: 44px;
        height: 44px;
        font-size: 1.5rem;
        border-radius: 10px;
    }
    .stat-value {
        font-size: 1.25rem;
    }
    .section-card,
    .reading-history-card,
    .book-mini-card {
        padding: 1rem;
        margin-bottom: 1.2rem;
        border-radius: 12px;
    }
    .book-mini-card img {
        width: 40px;
        height: 54px;
        border-radius: 4px;
    }
    .reading-history-title {
        font-size: 1rem;
        margin-bottom: 0.7rem;
    }
    .reading-book-item {
        padding: 0.7rem 0.8rem;
        margin-bottom: 0.5rem;
    }
    .activity-item {
        padding: 0.7rem 0.8rem;
        margin-bottom: 0.4rem;
        border-radius: 7px;
        text-align: center;
        justify-content: center !important;
        align-items: center !important;
    }
    .activity-avatar {
        width: 25px;
        height: 25px;
        font-size: 1rem;
        border-radius: 5px;
    }
    .row.g-3 {
        gap: 0.8rem !important;
        display: flex;
        flex-direction: column;
    }
    .col-md-4, .col-md-8 {
        width: 100%;
        max-width: 100%;
        flex: 0 0 100%;
    }
    .quick-actions .btn, .section-card .btn {
        justify-content: center;
        text-align: center;
    }
}

/* Desktop styles */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
    justify-items: center;
}

.stat-card {
    background: var(--soft-bg);
    border-radius: 16px;
    border: none;
    padding: 1.25rem 2rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    display: flex;
    align-items: center;
    gap: 1.25rem;
    min-height: 95px;
    transition: box-shadow 0.2s, transform 0.2s;
    width: 100%;
    max-width: 370px;
    margin-left: auto;
    margin-right: auto;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.10);
}

.stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 16px;
    background: var(--muted-bg);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    flex-shrink: 0;
}

.stat-icon i,
.stat-card .bi {
    color: var(--primary) !important;
}

.stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 0.1rem;
    line-height: 1.1;
    text-align: center;
}

.stat-label {
    font-size: 0.95rem;
    color: var(--accent);
    font-weight: 500;
    margin-bottom: 0.1rem;
}

.stat-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
    min-width: 0;
}

.section-card,
.reading-history-card,
.book-mini-card {
    background: var(--card-bg);
    border-radius: 16px;
    border: 1px solid var(--border);
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.quick-actions .btn,
.section-card .btn,
.reading-history-footer a {
    background: var(--muted-bg) !important;
    color: var(--primary) !important;
    border: none !important;
    box-shadow: none !important;
    font-weight: 500;
    border-radius: 8px !important;
    transition: background 0.18s;
    display: flex;
    align-items: center;
    gap: 0.7rem;
}

.quick-actions .btn:hover,
.section-card .btn:hover,
.reading-history-footer a:hover {
    background: var(--soft-bg) !important;
    color: var(--primary) !important;
}

.badge,
.book-mini-card .badge {
    background: var(--muted-bg) !important;
    color: var(--secondary) !important;
    font-size: 0.8rem;
    border-radius: 6px;
    padding: 2px 8px;
    border: none;
}

.book-mini-card {
    display: flex;
    gap: 1.2rem;
    align-items: center;
    background: var(--soft-bg);
    padding: 1.2rem;
    border-radius: 16px;
    border: 1px solid var(--border);
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.book-mini-card img {
    width: 54px;
    height: 74px;
    border-radius: 6px;
    object-fit: cover;
}

.book-mini-card .book-title {
    font-weight: 600;
    color: var(--primary);
}

.reading-history-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--primary);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.reading-book-item {
    background: var(--muted-bg);
    border-radius: 10px;
    padding: 0.9rem 1rem;
    margin-bottom: 0.7rem;
    border: 1px solid var(--border);
}

.reading-book-title {
    font-size: 1rem;
    font-weight: 500;
    margin-bottom: 2px;
    color: var(--primary);
}

.reading-book-meta {
    font-size: 0.88rem;
    color: var(--secondary);
    display: flex;
    align-items: center;
    gap: 0.4rem;
}

.reading-history-footer {
    text-align: center;
    margin-top: 1rem;
}

.reading-history-footer a {
    font-size: 0.95rem;
    color: var(--primary);
    text-decoration: none;
    background: var(--muted-bg);
    border-radius: 8px;
    padding: 0.5rem 0.9rem;
    display: inline-block;
    transition: background 0.2s;
    border: none;
}

.activity-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.85rem 1rem;
    background: var(--muted-bg);
    border-radius: 8px;
    margin-bottom: 0.5rem;
    border-left: 3px solid var(--border);
    transition: background 0.2s, border-color 0.2s;
    box-shadow: none;
}

.activity-item:hover {
    background: var(--soft-bg);
    border-left-color: var(--primary);
}

.activity-avatar {
    width: 32px;
    height: 32px;
    border-radius: 6px;
    background: var(--muted-bg);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
    font-size: 1.2rem;
    flex-shrink: 0;
}

.activity-details {
    flex: 1;
    min-width: 0;
}

.activity-title {
    font-size: 1rem;
    font-weight: 500;
    color: var(--primary);
    margin-bottom: 2px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.activity-meta {
    font-size: 0.85rem;
    color: var(--secondary);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.bi {
    color: var(--primary) !important;
}
</style>

<div class="dashboard-content">
    <!-- Welcome Header -->
    <div class="mb-4">
        <h2 class="mb-1">
            Welcome back, <strong><?= htmlspecialchars(explode(' ', $_SESSION['name'])[0]) ?></strong>! 👋
        </h2>
        <p class="text-muted mb-0">Here's what's happening with your library today</p>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <!-- Total Books -->
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="bi bi-book-fill"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value"><?= number_format($total_books ?? 0) ?></div>
                <div class="stat-label">Total Books</div>
            </div>
        </div>
        <!-- Total Users -->
        <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'librarian'): ?>
        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="bi bi-people-fill"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value"><?= number_format($total_users ?? 0) ?></div>
                <div class="stat-label">Total Users</div>
            </div>
        </div>
        <?php endif; ?>
        <!-- My Favorites -->
        <div class="stat-card">
            <div class="stat-icon pink">
                <i class="bi bi-heart-fill"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value"><?= number_format(count($my_favorites ?? [])) ?></div>
                <div class="stat-label">My Favorites</div>
            </div>
        </div>
        <!-- Books Read -->
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="bi bi-clock-history"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value"><?= number_format(count($my_history ?? [])) ?></div>
                <div class="stat-label">Books Read</div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-4">
            <div class="section-card quick-actions">
                <h5 class="mb-3" style="text-align:center;">
                    <i class="bi bi-lightning-charge-fill text-warning me-2"></i>
                    Quick Actions
                </h5>
                <div class="d-grid gap-2">
                    <a href="<?= BASE_URL ?>?route=books" class="btn btn-soft-primary">
                        <i class="bi bi-search me-2"></i>Browse Books
                    </a>
                    <a href="<?= BASE_URL ?>?route=favorites" class="btn btn-soft-secondary">
                        <i class="bi bi-heart-fill me-2"></i>My Favorites
                    </a>
                    <a href="<?= BASE_URL ?>?route=history" class="btn btn-soft-secondary">
                        <i class="bi bi-clock-history me-2"></i>Reading History
                    </a>
                    <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'librarian'): ?>
                        <a href="<?= BASE_URL ?>?route=books/create" class="btn btn-soft-warning">
                            <i class="bi bi-plus-circle me-2"></i>Add Book
                        </a>
                        <a href="<?= BASE_URL ?>?route=users" class="btn btn-soft-secondary">
                            <i class="bi bi-people me-2"></i>Manage Users
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (!empty($my_history)): ?>
            <div class="reading-history-card">
                <div class="reading-history-title" style="justify-content:center;">
                    <i class="bi bi-clock-history text-success"></i>
                    My Reading History
                </div>
                <?php foreach (array_slice($my_history, 0, 3) as $history): ?>
                    <div class="reading-book-item">
                        <div class="reading-book-title">
                            <?= htmlspecialchars($history['title'] ?? 'Unknown Book') ?>
                        </div>
                        <div class="reading-book-meta">
                            <i class="bi bi-clock"></i>
                            Last read:
                            <?php
                                $readDate = $history['read_at'] ?? $history['last_read'] ?? $history['created_at'] ?? null;
                                echo $readDate ? date('M d, Y', strtotime($readDate)) : 'Recently';
                            ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="reading-history-footer">
                    <a href="<?= BASE_URL ?>?route=history">View Full History</a>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <div class="col-md-8">
            <div class="section-card">
                <?php if ($_SESSION['role'] === 'admin' && !empty($activity_logs)): ?>
                    <h5 class="mb-3" style="text-align:center;">
                        <i class="bi bi-activity text-primary me-2"></i>
                        Recent Activity
                    </h5>
                    <?php foreach (array_slice($activity_logs, 0, 5) as $log): ?>
                        <div class="activity-item">
                            <div class="activity-avatar">
                                <i class="bi bi-circle-fill"></i>
                            </div>
                            <div class="activity-details">
                                <div class="activity-title">
                                    <strong><?= htmlspecialchars($log['user_name'] ?? 'User') ?></strong>
                                    <span class="text-muted"> - <?= htmlspecialchars($log['action'] ?? 'Unknown action') ?></span>
                                </div>
                                <div class="activity-meta">
                                    <i class="bi bi-clock"></i>
                                    <?php
                                    $timestamp = $log['created_at'] ?? $log['timestamp'] ?? $log['action_time'] ?? null;
                                    if ($timestamp && $timestamp != '0000-00-00 00:00:00') {
                                        echo date('M d, Y g:i A', strtotime($timestamp));
                                    } else {
                                        echo 'Recently';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php if (count($activity_logs) > 5): ?>
                        <a href="<?= BASE_URL ?>?route=logs" class="btn btn-soft-secondary btn-sm w-100 mt-2">
                            View All Activity
                        </a>
                    <?php endif; ?>
                <?php else: ?>
                    <h5 class="mb-3" style="text-align:center;">
                        <i class="bi bi-stars text-warning me-2"></i>
                        Recently Added Books
                    </h5>
                    <?php if (!empty($recent_books)): ?>
                        <div class="row g-2">
                            <?php foreach (array_slice($recent_books, 0, 4) as $book): ?>
                                <div class="col-md-6">
                                    <a href="<?= BASE_URL ?>?route=books/show&id=<?= $book['id'] ?>"
                                       class="text-decoration-none">
                                        <div class="book-mini-card">
                                            <div class="d-flex gap-3">
                                                <?php if (!empty($book['cover_image'])): ?>
                                                    <img src="<?= BASE_URL ?>uploads/covers/<?= htmlspecialchars($book['cover_image']) ?>"
                                                         alt="<?= htmlspecialchars($book['title']) ?>"
                                                         style="width: 50px; height: 70px; object-fit: cover; border-radius: 6px;">
                                                <?php else: ?>
                                                    <div style="width: 50px; height: 70px; background: #f0f0f0; border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                                                        <i class="bi bi-book text-muted"></i>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1" style="font-size: 0.875rem; line-height: 1.3;">
                                                        <?= htmlspecialchars(strlen($book['title']) > 40 ? substr($book['title'], 0, 40) . '...' : $book['title']) ?>
                                                    </h6>
                                                    <small class="text-muted d-block mb-1">
                                                        <i class="bi bi-person me-1"></i><?= htmlspecialchars($book['author']) ?>
                                                    </small>
                                                    <?php if (!empty($book['category'])): ?>
                                                        <span class="badge" style="background: #e6f2ff; color: #0066cc; font-size: 0.7rem;">
                                                            <?= htmlspecialchars($book['category']) ?>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <a href="<?= BASE_URL ?>?route=books" class="btn btn-soft-primary btn-sm w-100 mt-3">
                            <i class="bi bi-book me-1"></i> Browse All Books
                        </a>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="bi bi-inbox" style="font-size: 2.5rem; color: #cbd5e0;"></i>
                            <p class="text-muted mt-2 mb-0">No books available yet</p>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
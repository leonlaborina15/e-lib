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
.history-timeline {
    position: relative;
    padding-left: 2rem;
}

.history-timeline::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 2px;
    background: linear-gradient(to bottom, #22c55e, #e2e8f0);
}

.history-item {
    position: relative;
    background: white;
    border-radius: 12px;
    padding: 1.25rem;
    margin-bottom: 1rem;
    border: 1px solid #f0f0f0;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    transition: all 0.2s ease;
}

.history-item:hover {
    transform: translateX(4px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.history-item::before {
    content: '';
    position: absolute;
    left: -2.5rem;
    top: 1.5rem;
    width: 12px;
    height: 12px;
    background: #22c55e;
    border-radius: 50%;
    border: 3px solid white;
    box-shadow: 0 0 0 2px #22c55e;
}

.history-book-thumb {
    width: 70px;
    height: 100px;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

.history-book-placeholder {
    width: 70px;
    height: 100px;
    border-radius: 8px;
    background: #f0f0f0;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>

<!-- Page Header -->
<div class="mb-4">
    <h2 class="mb-1">Reading History</h2>
    <p class="text-muted mb-0">Track your reading journey</p>
</div>

<!-- Reading History -->
<?php if (empty($history)): ?>
    <div class="text-center py-5">
        <i class="bi bi-clock-history" style="font-size: 4rem; color: #cbd5e0;"></i>
        <h3 class="mt-3 mb-2">No reading history</h3>
        <p class="text-muted mb-4">Start reading books to build your history</p>
        <a href="<?= BASE_URL ?>?route=books" class="btn btn-soft-primary">
            <i class="bi bi-book me-1"></i> Browse Books
        </a>
    </div>
<?php else: ?>
    <div class="history-timeline">
        <?php foreach ($history as $book): ?>
            <div class="history-item">
                <div class="row g-3">
                    <!-- Book Thumbnail -->
                    <div class="col-auto">
                        <?php if (!empty($book['cover_image'])): ?>
                            <img src="<?= BASE_URL ?>uploads/covers/<?= htmlspecialchars($book['cover_image']) ?>"
                                 alt="<?= htmlspecialchars($book['title']) ?>"
                                 class="history-book-thumb">
                        <?php else: ?>
                            <div class="history-book-placeholder">
                                <i class="bi bi-book text-muted" style="font-size: 2rem;"></i>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Book Info -->
                    <div class="col">
                        <h5 class="mb-2">
                            <a href="<?= BASE_URL ?>?route=books/show&id=<?= $book['id'] ?>"
                               class="text-decoration-none text-dark">
                                <?= htmlspecialchars($book['title']) ?>
                            </a>
                        </h5>
                        <p class="text-muted mb-2">
                            <i class="bi bi-person me-1"></i>
                            <?= htmlspecialchars($book['author']) ?>
                        </p>

                        <?php if (!empty($book['category'])): ?>
                            <span class="badge mb-2" style="background: #e6f2ff; color: #0066cc; font-size: 0.75rem;">
                                <i class="bi bi-tag-fill me-1"></i>
                                <?= htmlspecialchars($book['category']) ?>
                            </span>
                        <?php endif; ?>

                        <!-- Read Date -->
                        <div class="mt-2">
                            <small class="text-muted">
                                <i class="bi bi-clock-history text-success me-1"></i>
                                Last read on <strong><?= date('M d, Y g:i A', strtotime($book['read_at'])) ?></strong>
                            </small>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="col-auto d-flex flex-column gap-2">
                        <a href="<?= BASE_URL ?>?route=books/show&id=<?= $book['id'] ?>"
                           class="btn btn-soft-primary btn-sm">
                            <i class="bi bi-eye me-1"></i> View
                        </a>
                        <?php if (!empty($book['pdf_file'])): ?>
                            <a href="<?= BASE_URL ?>?route=books/read&id=<?= $book['id'] ?>"
                               class="btn btn-soft-success btn-sm"
                               target="_blank">
                                <i class="bi bi-book-half me-1"></i> Read Again
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Stats -->
    <div class="text-center mt-4 pt-3 border-top">
        <p class="text-muted mb-0">
            <i class="bi bi-info-circle me-1"></i>
            You've read <strong><?= count($history) ?></strong> <?= count($history) === 1 ? 'book' : 'books' ?>
        </p>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
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
    --gold: #fbbf24;
    --danger: #dc3545;
}

.reviews-content {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 1rem;
}

.page-header {
    text-align: center;
    margin-bottom: 3rem;
}

.page-header h2 {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 0.5rem;
}

.page-header p {
    color: var(--secondary);
    font-size: 1.1rem;
}

/* Hide page header on mobile (sidebar already shows title) */
@media (max-width: 991px) {
    .page-header {
        display: none;
    }
}

.stats-bar {
    display: flex;
    justify-content: center;
    gap: 3rem;
    margin-bottom: 2rem;
    padding: 1.5rem 2rem;
    background: var(--soft-bg);
    border-radius: 12px;
    border: 1px solid var(--border);
}

.stat-item {
    text-align: center;
}

.stat-item .stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.3rem;
}

.stat-item .stat-label {
    font-size: 0.9rem;
    color: var(--secondary);
    margin-top: 0.3rem;
}

.review-form-card {
    background: var(--card-bg);
    border-radius: 16px;
    border: 1px solid var(--border);
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    padding: 2.5rem;
    margin-bottom: 3rem;
    max-width: 100%;
}

.review-form-card h5 {
    font-size: 1.3rem;
    font-weight: 600;
    color: var(--primary);
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-label {
    font-weight: 500;
    color: var(--primary);
    margin-bottom: 0.5rem;
    font-size: 0.95rem;
}

.form-control, .form-select {
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 0.75rem 1rem;
    font-size: 0.95rem;
    transition: border-color 0.2s, box-shadow 0.2s;
}

.form-control:focus, .form-select:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(35, 39, 47, 0.1);
}

.star-rating-select {
    display: flex;
    gap: 0.5rem;
    flex-direction: row-reverse;
    justify-content: flex-end;
    font-size: 2rem;
    margin-bottom: 1rem;
}

.star-rating-select input[type="radio"] {
    display: none;
}

.star-rating-select label {
    cursor: pointer;
    color: #ddd;
    transition: color 0.2s;
}

.star-rating-select input[type="radio"]:checked ~ label,
.star-rating-select label:hover,
.star-rating-select label:hover ~ label {
    color: var(--gold);
}

.btn-submit-review {
    background: var(--primary) !important;
    color: white !important;
    border: none !important;
    border-radius: 8px !important;
    padding: 0.75rem 2rem !important;
    font-weight: 500;
    transition: transform 0.2s, box-shadow 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    width: 100%;
}

.btn-submit-review:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(35, 39, 47, 0.2);
}

.reviews-list-card {
    background: var(--card-bg);
    border-radius: 16px;
    border: 1px solid var(--border);
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    padding: 2.5rem;
    max-width: 100%;
}

.reviews-list-card h5 {
    font-size: 1.3rem;
    font-weight: 600;
    color: var(--primary);
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.review-item {
    background: var(--soft-bg);
    border-radius: 12px;
    padding: 1.75rem;
    margin-bottom: 1rem;
    border: 1px solid var(--border);
    transition: transform 0.2s, box-shadow 0.2s;
    position: relative;
}

.review-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

.review-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
    gap: 1.5rem;
}

.reviewer-info {
    display: flex;
    align-items: center;
    gap: 1.25rem;
    flex: 1;
    min-width: 0;
}

.reviewer-avatar {
    width: 52px;
    height: 52px;
    min-width: 52px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 1.3rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    overflow: hidden;
}

.reviewer-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
}

.reviewer-details {
    flex: 1;
    min-width: 0;
}

.reviewer-details h6 {
    font-size: 1.05rem;
    font-weight: 600;
    color: var(--primary);
    margin-bottom: 0.2rem;
    word-wrap: break-word;
}

.review-date {
    font-size: 0.875rem;
    color: var(--secondary);
    display: flex;
    align-items: center;
    gap: 0.3rem;
}

.review-actions {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    align-items: flex-end;
}

.star-display {
    color: var(--gold);
    font-size: 1.3rem;
    letter-spacing: 2px;
    white-space: nowrap;
}

.review-text {
    color: var(--secondary);
    font-size: 1rem;
    line-height: 1.7;
    margin-top: 0.5rem;
    word-wrap: break-word;
}

.btn-delete-review {
    background: var(--danger) !important;
    color: white !important;
    border: none !important;
    border-radius: 6px !important;
    padding: 0.4rem 0.8rem !important;
    font-size: 0.85rem;
    font-weight: 500;
    transition: transform 0.2s, box-shadow 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    cursor: pointer;
    white-space: nowrap;
}

.btn-delete-review:hover {
    transform: scale(1.05);
    box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
}

.empty-state {
    text-align: center;
    padding: 3rem 1rem;
}

.empty-state i {
    font-size: 4rem;
    color: #cbd5e0;
    margin-bottom: 1rem;
}

.empty-state p {
    color: var(--secondary);
    font-size: 1.1rem;
}

.success-alert {
    background: #d1fae5;
    color: #065f46;
    border: 1px solid #6ee7b7;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.error-alert {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #fca5a5;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.admin-badge {
    background: var(--danger);
    color: white;
    font-size: 0.7rem;
    padding: 0.2rem 0.5rem;
    border-radius: 4px;
    font-weight: 600;
    margin-left: 0.5rem;
}

/* Mobile Responsive Styles */
@media (max-width: 768px) {
    .reviews-content {
        padding: 0;
    }

    .stats-bar {
        flex-direction: column;
        gap: 1rem;
        padding: 1rem;
        margin-left: 0.5rem;
        margin-right: 0.5rem;
        margin-bottom: 1.5rem;
        border-radius: 10px;
    }

    .stat-item .stat-number {
        font-size: 1.5rem;
    }

    .review-form-card,
    .reviews-list-card {
        padding: 1.25rem;
        margin-left: 0.5rem;
        margin-right: 0.5rem;
        border-radius: 12px;
    }

    .review-form-card {
        margin-bottom: 1.5rem;
    }

    .review-form-card h5,
    .reviews-list-card h5 {
        font-size: 1.1rem;
    }

    .review-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }

    .reviewer-info {
        width: 100%;
        gap: 1rem;
    }

    .reviewer-avatar {
        width: 50px;
        height: 50px;
        min-width: 50px;
        font-size: 1.2rem;
    }

    .reviewer-details h6 {
        font-size: 1rem;
    }

    .review-date {
        font-size: 0.85rem;
    }

    .review-actions {
        width: 100%;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
    }

    .star-display {
        font-size: 1.1rem;
        order: 1;
    }

    .btn-delete-review {
        order: 2;
        font-size: 0.8rem;
        padding: 0.35rem 0.6rem !important;
    }

    .review-text {
        font-size: 0.95rem;
        line-height: 1.6;
    }

    .review-item {
        padding: 1.25rem;
    }

    .star-rating-select {
        font-size: 1.5rem;
        justify-content: center;
    }

    .admin-badge {
        display: block;
        width: fit-content;
        margin: 0.5rem 0 0 0;
    }

    .form-control,
    .form-select {
        font-size: 1rem;
    }

    .btn-submit-review {
        font-size: 1rem;
    }
}

@media (max-width: 480px) {
    .reviews-content {
        padding: 0;
    }

    .stats-bar,
    .review-form-card,
    .reviews-list-card {
        margin-left: 0.25rem;
        margin-right: 0.25rem;
        padding: 1rem;
        border-radius: 10px;
    }

    .review-item {
        padding: 1rem;
        border-radius: 10px;
    }

    .reviewer-avatar {
        width: 48px;
        height: 48px;
        min-width: 48px;
        font-size: 1.1rem;
    }

    .reviewer-details h6 {
        font-size: 0.95rem;
    }

    .star-display {
        font-size: 1rem;
        letter-spacing: 1px;
    }

    .btn-delete-review {
        font-size: 0.75rem;
        padding: 0.3rem 0.5rem !important;
    }

    .btn-delete-review i {
        font-size: 0.75rem;
    }

    .review-text {
        font-size: 0.9rem;
        line-height: 1.5;
    }

    .form-control,
    .form-select {
        font-size: 0.95rem;
        padding: 0.65rem 0.85rem;
    }

    .btn-submit-review {
        padding: 0.65rem 1.25rem !important;
        font-size: 0.95rem;
    }
}


</style>

<div class="dashboard-content reviews-content">
    <!-- Page Header (Desktop Only) -->
    <div class="page-header">
        <h2>
            <i class="bi bi-star-fill" style="color: var(--gold);"></i>
            Website Reviews
        </h2>
        <p>Share your experience with our e-library platform</p>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="success-alert">
            <i class="bi bi-check-circle-fill"></i>
            <span><?= htmlspecialchars($_SESSION['success']) ?></span>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="error-alert">
            <i class="bi bi-exclamation-circle-fill"></i>
            <span><?= htmlspecialchars($_SESSION['error']) ?></span>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- Stats Bar -->
    <?php if (!empty($stats)): ?>
    <div class="stats-bar">
        <div class="stat-item">
            <div class="stat-number">
                <?= number_format($stats['avg_rating'] ?? 0, 1) ?>
                <i class="bi bi-star-fill" style="color: var(--gold); font-size: 1.5rem;"></i>
            </div>
            <div class="stat-label">Average Rating</div>
        </div>
        <div class="stat-item">
            <div class="stat-number"><?= number_format($stats['total_reviews'] ?? 0) ?></div>
            <div class="stat-label">Total Reviews</div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Review Form -->
    <div class="review-form-card">
        <h5>
            <i class="bi bi-pencil-square"></i>
            Leave a Review
        </h5>
        <form method="POST" action="<?= BASE_URL ?>?route=reviews/store">
            <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?? 0 ?>">

            <div class="mb-3">
                <label class="form-label">Your Name</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       required
                       value="<?= htmlspecialchars($_SESSION['name'] ?? '') ?>"
                       placeholder="Enter your name">
            </div>

            <div class="mb-3">
                <label class="form-label">Rating</label>
                <div class="star-rating-select">
                    <input type="radio" name="rating" id="star5" value="5" required>
                    <label for="star5">★</label>
                    <input type="radio" name="rating" id="star4" value="4">
                    <label for="star4">★</label>
                    <input type="radio" name="rating" id="star3" value="3">
                    <label for="star3">★</label>
                    <input type="radio" name="rating" id="star2" value="2">
                    <label for="star2">★</label>
                    <input type="radio" name="rating" id="star1" value="1">
                    <label for="star1">★</label>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Your Review</label>
                <textarea name="review_text"
                          class="form-control"
                          rows="4"
                          required
                          placeholder="Tell us about your experience with our e-library..."></textarea>
            </div>

            <button type="submit" class="btn-submit-review">
                <i class="bi bi-send-fill"></i>
                Submit Review
            </button>
        </form>
    </div>

    <!-- Reviews List -->
    <div class="reviews-list-card">
        <h5>
            <i class="bi bi-chat-quote"></i>
            What Our Users Say
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <span class="admin-badge">ADMIN VIEW</span>
            <?php endif; ?>
        </h5>

        <?php if (!empty($reviews)): ?>
            <?php foreach ($reviews as $row): ?>
                <div class="review-item">
                    <div class="review-header">
                        <div class="reviewer-info">
                            <div class="reviewer-avatar">
                                <?php if (!empty($row['user_photo'])): ?>
                                    <img src="<?= BASE_URL . 'uploads/photos/' . htmlspecialchars($row['user_photo']) ?>"
                                         alt="<?= htmlspecialchars($row['name']) ?>">
                                <?php else: ?>
                                    <?= strtoupper(substr($row['name'], 0, 1)) ?>
                                <?php endif; ?>
                            </div>
                            <div class="reviewer-details">
                                <h6><?= htmlspecialchars($row['name']) ?></h6>
                                <div class="review-date">
                                    <i class="bi bi-clock"></i>
                                    <?= date('F d, Y', strtotime($row['created_at'])) ?>
                                </div>
                            </div>
                        </div>
                        <div class="review-actions">
                            <div class="star-display">
                                <?= str_repeat('★', $row['rating']) ?><?= str_repeat('☆', 5 - $row['rating']) ?>
                            </div>
                            <?php if ($_SESSION['role'] === 'admin'): ?>
                                <button onclick="if(confirm('Are you sure you want to delete this review?')) window.location.href='<?= BASE_URL ?>?route=reviews/delete&id=<?= $row['id'] ?>'"
                                        class="btn-delete-review">
                                    <i class="bi bi-trash-fill"></i>
                                    Delete
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="review-text">
                        <?= nl2br(htmlspecialchars($row['review_text'])) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-state">
                <i class="bi bi-chat-left-quote"></i>
                <p>No reviews yet. Be the first to share your experience!</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
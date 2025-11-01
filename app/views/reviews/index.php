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
    max-width: 1200px;
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

.stats-bar {
    display: flex;
    justify-content: center;
    gap: 2rem;
    margin-bottom: 2rem;
    padding: 1.5rem;
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
    padding: 2rem;
    margin-bottom: 3rem;
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
    display: flex; /* Changed from inline-flex */
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
    padding: 2rem;
}

.reviews-list-card h5 {
    font-size: 1.3rem;
    font-weight: 600;
    color: var(--primary);
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.review-item {
    background: var(--soft-bg);
    border-radius: 12px;
    padding: 1.5rem;
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
    align-items: center;
    margin-bottom: 1rem;
}

.reviewer-info {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex: 1;
}

.reviewer-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: var(--muted-bg);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
    font-weight: 600;
    font-size: 1.2rem;
}

.reviewer-details {
    flex: 1;
}

.reviewer-details h6 {
    font-size: 1rem;
    font-weight: 600;
    color: var(--primary);
    margin-bottom: 0.2rem;
}

.review-date {
    font-size: 0.85rem;
    color: var(--secondary);
}

.review-actions {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.star-display {
    color: var(--gold);
    font-size: 1.2rem;
    letter-spacing: 2px;
}

.review-text {
    color: var(--secondary);
    font-size: 0.95rem;
    line-height: 1.6;
    margin-top: 0.5rem;
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

@media (max-width: 768px) {
    .page-header h2 {
        font-size: 1.8rem;
    }

    .stats-bar {
        flex-direction: column;
        gap: 1rem;
    }

    .review-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }

    .reviewer-info {
        width: 100%;
    }

    .star-display {
        font-size: 1rem;
    }

    .review-actions {
        width: 100%;
        justify-content: flex-end;
    }
}


</style>

<div class="dashboard-content reviews-content">
    <!-- Page Header -->
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
                                <?= strtoupper(substr($row['name'], 0, 1)) ?>
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
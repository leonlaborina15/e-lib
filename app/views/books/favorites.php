<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/sidebar.php';
?>

<!-- Page Header / Breadcrumb -->
<div class="mb-3">
    <a href="<?= BASE_URL ?>?route=books" class="btn btn-soft-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back to Books
    </a>
</div>


<!-- Favorites Grid -->
<?php if (empty($books)): ?>
    <div class="text-center py-5">
        <i class="bi bi-heart" style="font-size: 4rem; color: #cbd5e0;"></i>
        <h3 class="mt-3 mb-2">No favorite books yet</h3>
        <p class="text-muted mb-4">Start adding books to your favorites collection</p>
        <a href="<?= BASE_URL ?>?route=books" class="btn btn-soft-primary">
            <i class="bi bi-search me-1"></i> Browse Books
        </a>
    </div>
<?php else: ?>
    <div class="books-grid">
        <?php foreach ($books as $book): ?>
            <div class="book-card">
                <!-- Book Image -->
                <div class="book-card-image">
                    <?php if (!empty($book['cover_image'])): ?>
                        <img src="<?= BASE_URL ?>uploads/covers/<?= htmlspecialchars($book['cover_image']) ?>"
                             alt="<?= htmlspecialchars($book['title']) ?>"
                             onerror="this.parentElement.innerHTML='<div class=\'d-flex align-items-center justify-content-center h-100 bg-light\'><i class=\'bi bi-book\' style=\'font-size: 2rem; color: #cbd5e0;\'></i></div>'">
                    <?php else: ?>
                        <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                            <i class="bi bi-book" style="font-size: 2rem; color: #cbd5e0;"></i>
                        </div>
                    <?php endif; ?>

                    <!-- Favorited Date Badge (bottom-left) -->
                    <?php if (!empty($book['favorited_at'])): ?>
                        <div style="position: absolute; bottom: 12px; left: 12px;">
                            <span style="background: rgba(0, 0, 0, 0.7); color: white; padding: 0.35em 0.75em; border-radius: 20px; font-size: 0.75rem;">
                                <i class="bi bi-clock me-1"></i>
                                <?= date('M d, Y', strtotime($book['favorited_at'])) ?>
                            </span>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Book Info -->
                <div class="book-card-body">
                    <h5 class="book-title" title="<?= htmlspecialchars($book['title']) ?>">
                        <?= htmlspecialchars($book['title']) ?>
                    </h5>
                    <p class="book-author">
                        <i class="bi bi-person me-1"></i>
                        <?= htmlspecialchars($book['author']) ?>
                    </p>
                    <?php if (!empty($book['category'])): ?>
                        <span class="book-category">
                            <i class="bi bi-tag-fill me-1"></i>
                            <?= htmlspecialchars($book['category']) ?>
                        </span>
                    <?php endif; ?>
                    <div class="d-grid gap-2 mt-3">
                        <a href="<?= BASE_URL ?>?route=books/show&id=<?= $book['id'] ?>"
                           class="btn btn-soft-primary btn-sm">
                            <i class="bi bi-eye me-1"></i> View Details
                        </a>
                        <a href="<?= BASE_URL ?>?route=books/toggleFavorite&book_id=<?= $book['id'] ?>"
                           class="btn btn-soft-danger btn-sm"
                           onclick="return confirm('Remove this book from your favorites?')">
                            <i class="bi bi-x-circle me-1"></i> Remove from Favorites
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <!-- Stats -->
    <div class="text-center mt-4 pt-3 border-top">
        <p class="text-muted mb-0">
            <i class="bi bi-info-circle me-1"></i>
            You have <strong><?= count($books) ?></strong> favorite <?= count($books) === 1 ? 'book' : 'books' ?>
        </p>
    </div>
<?php endif; ?>

<style>
:root {
    --primary: #23272f;
    --card-bg: #fff;
    --soft-bg: #f6f8fa;
    --border: #e6e8ec;
    --muted-bg: #f3f4f6;
    --secondary: #7b8191;
}

/* Grid Layout */
.books-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 0.9rem;
}

/* Book Card Base Styles */
.book-card {
    background: var(--card-bg);
    border-radius: 24px;
    box-shadow: 0 1px 4px rgba(30,30,30,0.05);
    font-size: 0.96rem;
    min-width: 0;
    position: relative;
    display: flex;
    flex-direction: column;
    transition: box-shadow 0.15s;
    padding: 0.7rem 0.6rem;
}

.book-card:hover {
    box-shadow: 0 4px 14px rgba(30,30,30,0.11);
}

/* Book Card Image */
.book-card-image {
    width: 100%;
    height: 120px;
    border-radius: 8px;
    overflow: hidden;
    background: var(--muted-bg);
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 0.5rem;
}

.book-card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.book-title {
    font-size: 1rem;
    font-weight: 600;
    color: var(--primary);
    margin-bottom: 0.15rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.book-author {
    font-size: 0.89rem;
    color: var(--secondary);
    margin-bottom: 0.13rem;
}

.book-category {
    font-size: 0.82rem;
    background: var(--muted-bg);
    color: var(--secondary);
    border-radius: 6px;
    padding: 2px 8px;
    font-weight: 500;
    display: inline-block;
    margin-bottom: 0.4rem;
}

.book-card .btn {
    font-size: 0.86rem;
    border-radius: 6px;
    font-weight: 500;
    border: none;
    box-shadow: none;
    padding: 0.25em 0;
    margin-bottom: 0.14em;
    width: 100%;
    text-align: left;
    display: flex;
    align-items: center;
    gap: 0.55em;
}

.btn-soft-primary {
    background: #eaf2ff !important;
    color: var(--primary) !important;
}

.btn-soft-danger {
    background: #ffebeb !important;
    color: #d90429 !important;
}

/* Mobile Responsive Styles: 1 Card Per Row and Horizontal Card Layout */
@media (max-width: 768px) {
    .books-grid {
        grid-template-columns: 1fr; /* One card per row */
        gap: 0.7rem;
    }
    .book-card {
        flex-direction: row; /* Horizontal layout */
        align-items: center;
        min-height: 120px;
        padding: 0.4rem 0.3rem;
        border-radius: 24px;
    }
    .book-card-image {
        width: 46%;
        height: 120px;
        min-width: 110px;
        max-width: 170px;
        margin-bottom: 0;
        margin-right: 1.1rem;
        border-radius: 18px;
        flex-shrink: 0;
    }
    .book-card-body {
        width: 54%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .book-title, .book-author, .book-category {
        white-space: normal;
        overflow: visible;
        text-overflow: unset;
    }
    .book-card .btn {
        width: 100%;
        justify-content: flex-start;
        margin-bottom: 0.28em;
        padding-left: 0.5em;
        border-radius: 10px;
    }
}
</style>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
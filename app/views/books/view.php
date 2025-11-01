<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/sidebar.php';
?>

<style>
.book-detail-wrapper {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    gap: 2.5rem;
    align-items: flex-start;
    flex-direction: row;
}
.book-detail-left {
    flex: 0 0 340px;
    display: flex;
    flex-direction: column;
    align-items: center;
}
.book-cover-portrait-frame {
    width: 100%;
    max-width: 320px;
    height: 450px; /* Always portrait! */
    background: #f8f9fa;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 12px 40px rgba(0,0,0,0.14);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    position: relative;
}
.book-cover-portrait {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Crop image to fit portrait frame */
    display: block;
}
.book-cover-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #f0f0f0 0%, #e0e0e0 100%);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.favorite-btn-bottom {
    display: flex;
    justify-content: center;
    margin-top: 1.1rem;
}
.favorite-btn-bottom a, .favorite-btn-bottom button {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: #fff0f0;
    border: 2px solid #ffd6e7;
    color: #ec4899;
    border-radius: 50px;
    padding: 0.65em 1.5em;
    font-size: 1.09rem;
    font-weight: 500;
    transition: all 0.2s;
    text-decoration: none;
    cursor: pointer;
}
.favorite-btn-bottom a.active, .favorite-btn-bottom button.active {
    background: #ec4899;
    color: #fff;
    border-color: #ec4899;
}
.favorite-btn-bottom a:hover, .favorite-btn-bottom button:hover {
    background: #ffe6f0;
    color: #d90429;
    box-shadow: 0 4px 12px rgba(236, 72, 153, 0.14);
}
.book-detail-right {
    flex: 1 1 0;
    min-width: 0;
}
.book-detail-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    border: 1px solid #f0f0f0;
    width: 100%;
    margin: 0 auto;
    position: relative;
}
.book-detail-title-row {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    gap: 1rem;
    flex-wrap: wrap;
    margin-bottom: 0.4rem;
}
.book-detail-title {
    font-size: 2rem;
    font-weight: 700;
    color: #2d3748;
    line-height: 1.25;
    margin-bottom: 0;
    word-break: break-word;
}
.book-detail-author {
    font-size: 1.11rem;
    color: #718096;
    margin-bottom: 1.2rem;
    word-break: break-word;
}
.book-meta-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
    margin-bottom: 2rem;
}
.book-meta-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.8rem;
    background: #f8f9fa;
    border-radius: 12px;
    transition: background 0.2s;
}
.book-meta-item:hover {
    background: #f0f7ff;
    transform: translateY(-2px);
}
.book-meta-icon {
    width: 38px;
    height: 38px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #e6f2ff;
    color: #0066cc;
    font-size: 1.12rem;
    flex-shrink: 0;
}
.book-description-section {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 0.8rem 1rem;
    margin-bottom: 2rem;
}
.book-description {
    line-height: 1.7;
    color: #4a5568;
    font-size: 1rem;
}
.action-buttons-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(170px, 1fr));
    gap: 0.65rem;
}
/* Mobile - Portrait Fix */
@media (max-width: 900px) {
    .book-detail-wrapper {
        flex-direction: column;
        gap: 0;
        max-width: 100vw;
        align-items: stretch;
    }
    .book-detail-left, .book-detail-right {
        max-width: 100%;
    }
    .book-detail-left {
        width: 100%;
    }
    .book-detail-card {
        margin-top: 1.5rem;
        padding: 1.1rem;
    }
    .book-detail-title-row {
        flex-direction: row;
        gap: 0.7rem;
        justify-content: flex-start;
    }
    .book-detail-title {
        font-size: 1.45rem;
    }
    .book-cover-portrait-frame,
    .book-cover-placeholder {
        width: 70vw;
        max-width: 320px;
        height: calc(70vw * 1.4); /* Portrait ratio */
        max-height: 450px;
        margin-left: auto;
        margin-right: auto;
    }
    .book-meta-grid {
        grid-template-columns: 1fr;
    }
    .book-meta-item {
        font-size: 0.97rem;
        padding: 0.7rem;
    }
    .action-buttons-grid {
        grid-template-columns: 1fr;
        gap: 0.5rem;
    }
    .book-description-section {
        padding: 0.8rem 0.7rem;
    }
}
@media (max-width: 540px) {
    .book-detail-title {
        font-size: 1.22rem;
    }
    .book-cover-portrait-frame,
    .book-cover-placeholder {
        width: 90vw;
        max-width: 260px;
        height: calc(90vw * 1.4); /* Portrait ratio */
        max-height: 360px;
        margin-left: auto;
        margin-right: auto;
    }
    .book-detail-card {
        padding: 0.7rem;
    }
}
</style>

<!-- Back Button -->
<div class="mb-3">
    <a href="<?= BASE_URL ?>?route=books" class="btn btn-soft-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back to Books
    </a>
</div>

<div class="book-detail-wrapper">
    <!-- Left: Book Cover (always portrait) + Favorite Button at Bottom -->
    <div class="book-detail-left">
        <div class="book-cover-portrait-frame">
            <?php if (!empty($book['cover_image'])): ?>
                <img src="<?= BASE_URL ?>uploads/covers/<?= htmlspecialchars($book['cover_image']) ?>"
                     alt="<?= htmlspecialchars($book['title']) ?>"
                     class="book-cover-portrait"
                     onerror="this.parentElement.innerHTML='<div class=\'book-cover-placeholder\'><i class=\'bi bi-book\' style=\'font-size: 6rem; color: #cbd5e0;\'></i></div>'">
            <?php else: ?>
                <div class="book-cover-placeholder">
                    <i class="bi bi-book" style="font-size: 6rem; color: #cbd5e0;"></i>
                </div>
            <?php endif; ?>
        </div>
        <div class="favorite-btn-bottom">
            <a href="<?= BASE_URL ?>?route=books/toggleFavorite&book_id=<?= $book['id'] ?>"
               class="<?= $is_favorited ? 'active' : '' ?>"
               title="<?= $is_favorited ? 'In Your Favorites' : 'Add to Favorites' ?>">
                <i class="bi bi-heart<?= $is_favorited ? '-fill' : '' ?>"></i>
                <?= $is_favorited ? 'Favorited' : 'Add to Favorites' ?>
            </a>
        </div>
    </div>

    <!-- Right: Book Details + Actions -->
    <div class="book-detail-right">
        <div class="book-detail-card">
            <div class="book-detail-title-row">
                <h1 class="book-detail-title"><?= htmlspecialchars($book['title']) ?></h1>
            </div>
            <p class="book-detail-author">
                <i class="bi bi-person-circle me-2"></i>
                by <?= htmlspecialchars($book['author']) ?>
            </p>

            <!-- Metadata Grid -->
            <div class="book-meta-grid">
                <?php if (!empty($book['category'])): ?>
                <div class="book-meta-item">
                    <div class="book-meta-icon">
                        <i class="bi bi-tag-fill"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Category</small>
                        <strong><?= htmlspecialchars($book['category']) ?></strong>
                    </div>
                </div>
                <?php endif; ?>

                <?php if (!empty($book['publisher'])): ?>
                <div class="book-meta-item">
                    <div class="book-meta-icon">
                        <i class="bi bi-building"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Publisher</small>
                        <strong><?= htmlspecialchars($book['publisher']) ?></strong>
                    </div>
                </div>
                <?php endif; ?>

                <?php if (!empty($book['published_year'])): ?>
                <div class="book-meta-item">
                    <div class="book-meta-icon">
                        <i class="bi bi-calendar-event"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Published Year</small>
                        <strong><?= htmlspecialchars($book['published_year']) ?></strong>
                    </div>
                </div>
                <?php endif; ?>

                <div class="book-meta-item">
                    <div class="book-meta-icon">
                        <i class="bi bi-clock"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Added to Library</small>
                        <strong><?= date('M d, Y', strtotime($book['created_at'])) ?></strong>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <?php if (!empty($book['description'])): ?>
            <div class="book-description-section">
                <h5 class="mb-3">
                    <i class="bi bi-file-text me-2"></i>About This Book
                </h5>
                <div class="book-description"><?= nl2br(htmlspecialchars($book['description'])) ?></div>
            </div>
            <?php endif; ?>

            <!-- Action Buttons -->
            <?php if (!empty($book['pdf_file'])): ?>
                <div class="action-buttons-grid mb-3">
                    <a href="<?= BASE_URL ?>?route=books/read&id=<?= $book['id'] ?>"
                       class="btn btn-soft-success btn-lg"
                       target="_blank">
                        <i class="bi bi-book-half me-2"></i> Read Offline
                    </a>
                    <a href="<?= BASE_URL ?>?route=books/download&id=<?= $book['id'] ?>"
                       class="btn btn-soft-primary btn-lg">
                        <i class="bi bi-download me-2"></i> Download PDF
                    </a>
                </div>
            <?php else: ?>
                <div class="alert alert-warning mb-3">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>PDF file not available</strong> for this book
                </div>
            <?php endif; ?>

            <!-- Admin/Librarian Actions -->
            <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'librarian'): ?>
                <div class="action-buttons-grid">
                    <a href="<?= BASE_URL ?>?route=books/edit&id=<?= $book['id'] ?>"
                       class="btn btn-soft-warning btn-lg">
                        <i class="bi bi-pencil me-2"></i> Edit Book
                    </a>
                    <?php if ($_SESSION['role'] === 'admin'): ?>
                        <button onclick="deleteBook(<?= $book['id'] ?>, '<?= htmlspecialchars($book['title'], ENT_QUOTES) ?>')"
                                class="btn btn-soft-danger btn-lg">
                            <i class="bi bi-trash me-2"></i> Delete Book
                        </button>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function deleteBook(bookId, bookTitle) {
    if (confirm('⚠️ Are you sure you want to delete "' + bookTitle + '"?\n\nThis action cannot be undone!')) {
        window.location.href = '<?= BASE_URL ?>?route=books/delete&id=' + bookId;
    }
}
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
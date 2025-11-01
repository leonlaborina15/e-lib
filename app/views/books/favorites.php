<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/sidebar.php';
?>

<!-- Page Header -->
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h2 class="mb-1">
                <i class="bi bi-heart-fill text-danger me-2"></i>
                My Favorites
            </h2>
            <p class="text-muted mb-0">Your personal collection of beloved books</p>
        </div>
        <a href="<?= BASE_URL ?>?route=books" class="btn btn-soft-secondary">
            <i class="bi bi-arrow-left me-1"></i> Browse Books
        </a>
    </div>
</div>

<!-- Search Bar for Favorites -->
<?php if (!empty($books)): ?>
<div class="search-bar-wrapper mb-4">
    <i class="bi bi-search"></i>
    <input type="text"
           class="form-control"
           id="searchInput"
           placeholder="Search your favorite books..."
           onkeyup="searchFavorites()">
</div>
<?php endif; ?>

<!-- Favorites Grid -->
<?php if (empty($books)): ?>
    <div class="empty-state text-center py-5">
        <div class="empty-icon">
            <i class="bi bi-heart"></i>
        </div>
        <h3 class="mt-4 mb-2">No favorite books yet</h3>
        <p class="text-muted mb-4">Start building your collection by adding books you love!</p>
        <a href="<?= BASE_URL ?>?route=books" class="btn btn-soft-primary btn-lg">
            <i class="bi bi-book me-2"></i> Browse Books
        </a>
    </div>
<?php else: ?>
    <div class="books-grid" id="favoritesContainer">
        <?php foreach ($books as $book): ?>
            <div class="book-card"
                 data-title="<?= strtolower(htmlspecialchars($book['title'])) ?>"
                 data-author="<?= strtolower(htmlspecialchars($book['author'])) ?>"
                 data-category="<?= strtolower(htmlspecialchars($book['category'] ?? '')) ?>">
                <!-- Book Image -->
                <div class="book-card-image">
                    <?php if (!empty($book['cover_image'])): ?>
                        <img src="<?= BASE_URL ?>uploads/covers/<?= htmlspecialchars($book['cover_image']) ?>"
                             alt="<?= htmlspecialchars($book['title']) ?>"
                             loading="lazy"
                             onerror="this.parentElement.innerHTML='<div class=\'d-flex align-items-center justify-content-center h-100 bg-light\'><i class=\'bi bi-book\' style=\'font-size: 2rem; color: #cbd5e0;\'></i></div>'">
                    <?php else: ?>
                        <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                            <i class="bi bi-book" style="font-size: 2rem; color: #cbd5e0;"></i>
                        </div>
                    <?php endif; ?>

                    <!-- Heart Badge (top-right) -->
                    <div class="favorite-badge">
                        <i class="bi bi-heart-fill"></i>
                    </div>

                    <!-- Favorited Date Badge (bottom) -->
                    <?php if (!empty($book['favorited_at'])): ?>
                        <div class="date-badge">
                            <i class="bi bi-clock me-1"></i>
                            <?= date('M d, Y', strtotime($book['favorited_at'])) ?>
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
                    <div class="d-grid gap-1 mt-2">
                        <a href="<?= BASE_URL ?>?route=books/show&id=<?= $book['id'] ?>"
                           class="btn btn-soft-primary btn-sm">
                            <i class="bi bi-eye me-1"></i> View Details
                        </a>
                        <button onclick="removeFavorite(<?= $book['id'] ?>, '<?= htmlspecialchars($book['title'], ENT_QUOTES) ?>')"
                                class="btn btn-soft-danger btn-sm">
                            <i class="bi bi-heart-break me-1"></i> Remove
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Stats -->
    <div class="text-center mt-4 pt-3 border-top">
        <p class="text-muted mb-0" id="statsCount">
            <i class="bi bi-heart-fill text-danger me-1"></i>
            You have <strong><?= count($books) ?></strong> favorite <?= count($books) === 1 ? 'book' : 'books' ?>
        </p>
    </div>
<?php endif; ?>

<script>
// Search functionality
function searchFavorites() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const cards = document.querySelectorAll('.book-card');
    let visibleCount = 0;

    cards.forEach(card => {
        const title = card.getAttribute('data-title');
        const author = card.getAttribute('data-author');
        const category = card.getAttribute('data-category');

        if (title.includes(filter) || author.includes(filter) || category.includes(filter)) {
            card.style.display = '';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    // Update stats count
    const statsCount = document.getElementById('statsCount');
    if (statsCount) {
        const total = cards.length;
        if (visibleCount === 0 && filter !== '') {
            statsCount.innerHTML = `
                <i class="bi bi-search me-1"></i>
                No favorites match "<strong>${filter}</strong>"
            `;
        } else if (filter !== '') {
            statsCount.innerHTML = `
                <i class="bi bi-funnel-fill me-1"></i>
                Showing <strong>${visibleCount}</strong> of <strong>${total}</strong> favorites
            `;
        } else {
            statsCount.innerHTML = `
                <i class="bi bi-heart-fill text-danger me-1"></i>
                You have <strong>${total}</strong> favorite ${total === 1 ? 'book' : 'books'}
            `;
        }
    }
}

// Remove from favorites with confirmation
function removeFavorite(bookId, bookTitle) {
    Swal.fire({
        title: 'Remove from Favorites?',
        html: `
            <p>Are you sure you want to remove:</p>
            <strong class="text-danger">${bookTitle}</strong>
            <p class="text-muted mt-2"><small>You can always add it back later!</small></p>
        `,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="bi bi-heart-break me-1"></i> Yes, Remove',
        cancelButtonText: '<i class="bi bi-x-circle me-1"></i> Cancel',
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-secondary'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            // Add loading state
            Swal.fire({
                title: 'Removing...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Redirect to remove
            window.location.href = '<?= BASE_URL ?>?route=books/favorite&book_id=' + bookId;
        }
    });
}

// Add animation on page load
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.book-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.4s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 50);
    });
});
</script>

<style>
:root {
    --primary: var(--text);
    --card-bg: var(--bg);
    --soft-bg: var(--bg-subtle);
    --border: var(--border);
    --muted-bg: var(--bg-muted);
    --secondary: var(--text-subtle);
}

/* ============================================
   SEARCH BAR
   ============================================ */
.search-bar-wrapper {
    position: relative;
    max-width: 600px;
    margin: 0 auto;
}

.search-bar-wrapper i {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted);
    font-size: 1rem;
}

.search-bar-wrapper .form-control {
    padding-left: 2.5rem;
    border-radius: 12px;
    border: 2px solid var(--border);
    transition: all 0.3s ease;
}

.search-bar-wrapper .form-control:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

/* ============================================
   EMPTY STATE
   ============================================ */
.empty-state {
    max-width: 500px;
    margin: 4rem auto;
}

.empty-icon {
    width: 120px;
    height: 120px;
    margin: 0 auto;
    background: var(--bg-muted);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: pulse 2s infinite;
}

.empty-icon i {
    font-size: 4rem;
    color: #cbd5e0;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

/* ============================================
   BOOKS GRID - IMPROVED
   ============================================ */
.books-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 1rem;
}

.book-card {
    background: var(--card-bg);
    border-radius: 16px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    min-width: 0;
    position: relative;
    display: flex;
    flex-direction: column;
    transition: all 0.3s ease;
    padding: 0.75rem;
    border: 1px solid var(--border);
}

.book-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.15);
}

/* Book Card Image */
.book-card-image {
    width: 100%;
    height: 180px;
    border-radius: 12px;
    overflow: hidden;
    background: var(--muted-bg);
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 0.75rem;
}

.book-card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.3s ease;
}

.book-card:hover .book-card-image img {
    transform: scale(1.05);
}

/* Favorite Heart Badge */
.favorite-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 36px;
    height: 36px;
    background: rgba(239, 68, 68, 0.95);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
    animation: heartbeat 1.5s infinite;
}

.favorite-badge i {
    color: white;
    font-size: 1.1rem;
}

@keyframes heartbeat {
    0%, 100% { transform: scale(1); }
    10%, 30% { transform: scale(1.1); }
    20%, 40% { transform: scale(1); }
}

/* Date Badge */
.date-badge {
    position: absolute;
    bottom: 10px;
    left: 10px;
    background: rgba(0, 0, 0, 0.75);
    backdrop-filter: blur(8px);
    color: white;
    padding: 0.4rem 0.75rem;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

/* Book Title - Multi-line support */
.book-title {
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--text);
    margin-bottom: 0.5rem;
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    word-break: break-word;
    min-height: 2.6em;
}

.book-author {
    font-size: 0.85rem;
    color: var(--text-subtle);
    margin-bottom: 0.5rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.book-category {
    font-size: 0.75rem;
    background: var(--muted-bg);
    color: var(--text-subtle);
    border-radius: 6px;
    padding: 0.25rem 0.5rem;
    font-weight: 500;
    display: inline-block;
    margin-bottom: 0.5rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 100%;
}

.book-card .btn {
    font-size: 0.85rem;
    border-radius: 8px;
    font-weight: 500;
    border: none;
    box-shadow: none;
    padding: 0.4rem 0.5rem;
    margin-bottom: 0.25rem;
    width: 100%;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: all 0.2s ease;
}

.btn-soft-primary {
    background: #eaf2ff !important;
    color: var(--text) !important;
}

.btn-soft-primary:hover {
    background: #d4e8ff !important;
    transform: translateY(-2px);
}

.btn-soft-danger {
    background: #ffebeb !important;
    color: #d90429 !important;
}

.btn-soft-danger:hover {
    background: #ffd1d1 !important;
    transform: translateY(-2px);
}

.btn-soft-secondary {
    background: var(--muted-bg) !important;
    color: var(--text) !important;
}

/* ============================================
   MOBILE RESPONSIVE
   ============================================ */
@media (max-width: 768px) {
    .books-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .book-card {
        display: flex;
        flex-direction: row;
        align-items: stretch;
        padding: 0;
        min-height: 180px;
    }

    .book-card-image {
        width: 35%;
        height: auto;
        min-height: 180px;
        margin: 0;
        border-radius: 16px 0 0 16px;
    }

    .book-card-body {
        width: 65%;
        padding: 1rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .book-title {
        font-size: 0.9rem;
        -webkit-line-clamp: 2;
        min-height: auto;
    }

    .book-author {
        font-size: 0.8rem;
    }

    .book-category {
        font-size: 0.7rem;
        padding: 0.2rem 0.4rem;
    }

    .book-card .btn {
        font-size: 0.8rem;
        padding: 0.5rem;
    }

    .favorite-badge {
        width: 32px;
        height: 32px;
    }

    .favorite-badge i {
        font-size: 0.9rem;
    }

    .date-badge {
        font-size: 0.65rem;
        padding: 0.3rem 0.6rem;
    }
}

/* Dark theme improvements */
body.dark-theme .book-card {
    box-shadow: 0 1px 3px rgba(0,0,0,0.3);
}

body.dark-theme .book-card:hover {
    box-shadow: 0 12px 24px rgba(0,0,0,0.4);
}

body.dark-theme .search-bar-wrapper .form-control:focus {
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
}

body.dark-theme .empty-icon {
    background: var(--bg-subtle);
}
</style>


<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
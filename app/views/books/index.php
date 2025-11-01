<?php

require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/sidebar.php';
?>

<!-- Page Header -->
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="mb-1">Browse Books</h2>
            <p class="text-muted mb-0">Discover and explore our collection</p>
        </div>
        <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'librarian'): ?>
            <a href="<?= BASE_URL ?>?route=books/create" class="btn btn-soft-primary">
                <i class="bi bi-plus-circle me-1"></i> Add Book
            </a>
        <?php endif; ?>
    </div>
</div>

<!-- Search Bar -->
<div class="search-bar-wrapper mb-4">
    <i class="bi bi-search"></i>
    <input type="text"
           class="form-control"
           id="searchInput"
           placeholder="Search books by title, author, category, or ISBN..."
           onkeyup="searchBooks()">
</div>

<!-- Category Filters -->
<div class="category-filters-wrapper mb-4">
    <div class="category-filters" id="categoryFilters">
        <a href="<?= BASE_URL ?>?route=books"
           class="category-badge <?= !$current_category ? 'active' : '' ?>">
            All Categories
        </a>
        <?php foreach ($categories as $cat): ?>
            <a href="<?= BASE_URL ?>?route=books&category=<?= urlencode($cat) ?>"
               class="category-badge <?= $current_category === $cat ? 'active' : '' ?>">
                <?= htmlspecialchars($cat) ?>
            </a>
        <?php endforeach; ?>
    </div>
    <!-- Scroll indicators -->
    <div class="scroll-indicator scroll-left" id="scrollLeft">
        <i class="bi bi-chevron-left"></i>
    </div>
    <div class="scroll-indicator scroll-right" id="scrollRight">
        <i class="bi bi-chevron-right"></i>
    </div>
</div>

<!-- Books Grid -->
<?php if (empty($books)): ?>
    <div class="text-center py-5">
        <i class="bi bi-book" style="font-size: 4rem; color: #cbd5e0;"></i>
        <h3 class="mt-3 mb-2">No books found</h3>
        <p class="text-muted mb-4">
            <?php if ($current_category): ?>
                No books available in this category yet.
            <?php else: ?>
                Start building your library by adding books.
            <?php endif; ?>
        </p>
        <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'librarian'): ?>
            <a href="<?= BASE_URL ?>?route=books/create" class="btn btn-soft-primary">
                <i class="bi bi-plus-circle me-1"></i> Add First Book
            </a>
        <?php endif; ?>
    </div>
<?php else: ?>
    <div class="books-grid" id="booksContainer">
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
                    <?php if ($book['is_favorited']): ?>
                        <div style="position: absolute; top: 10px; right: 10px;">
                            <i class="bi bi-heart-fill" style="color: #ef4444; font-size: 1.2rem; filter: drop-shadow(0 1px 2px rgba(0,0,0,0.2));"></i>
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
                        <a href="<?= BASE_URL ?>?route=books/show&id=<?= $book['id'] ?>" class="btn btn-soft-primary btn-sm">
                            <i class="bi bi-eye me-1"></i> View
                        </a>
                        <a href="<?= BASE_URL ?>?route=books/favorite&book_id=<?= $book['id'] ?>"
                           class="btn btn-soft-secondary btn-sm btn-favorite <?= $book['is_favorited'] ? 'favorited' : '' ?>">
                            <i class="bi bi-heart<?= $book['is_favorited'] ? '-fill' : '' ?> me-1"></i>
                            <?= $book['is_favorited'] ? 'Favorited' : 'Favorite' ?>
                        </a>
                        <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'librarian'): ?>
                            <a href="<?= BASE_URL ?>?route=books/edit&id=<?= $book['id'] ?>" class="btn btn-soft-warning btn-sm">
                                <i class="bi bi-pencil me-1"></i> Edit
                            </a>
                        <?php endif; ?>
                        <?php if ($_SESSION['role'] === 'admin'): ?>
                            <button onclick="deleteBook(<?= $book['id'] ?>, '<?= htmlspecialchars($book['title'], ENT_QUOTES) ?>')"
                                    class="btn btn-soft-danger btn-sm">
                                <i class="bi bi-trash me-1"></i> Delete
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Modern Pagination Controls (UI Only) -->
    <div id="paginationControls" class="modern-pagination-controls"></div>

    <!-- Results Count -->
    <div class="text-center mt-3 pt-2 border-top">
        <p class="text-muted mb-0" id="resultsCount">
            <i class="bi bi-info-circle me-1"></i>
            Showing <strong><?= count($books) ?></strong>
            <?= count($books) === 1 ? 'book' : 'books' ?>
            <?= $current_category ? 'in <strong>' . htmlspecialchars($current_category) . '</strong>' : '' ?>
        </p>
    </div>
<?php endif; ?>

<script>
// Real-time search
function searchBooks() {
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

    // Show "no results" message
    const container = document.getElementById('booksContainer');
    let noResults = document.getElementById('noResultsMessage');

    if (visibleCount === 0 && filter !== '') {
        if (!noResults) {
            noResults = document.createElement('div');
            noResults.id = 'noResultsMessage';
            noResults.className = 'text-center py-5';
            noResults.innerHTML = `
                <i class="bi bi-search" style="font-size: 2rem; color: #cbd5e0;"></i>
                <h4 class="mt-3 mb-2">No books found</h4>
                <p class="text-muted">Try searching with different keywords</p>
            `;
            container.after(noResults);
        }
        noResults.style.display = 'block';
    } else if (noResults) {
        noResults.style.display = 'none';
    }

    // Update pagination after search
    setupPaginationUI();
}

// Delete book with confirmation
function deleteBook(bookId, bookTitle) {
    if (confirm('⚠️ Are you sure you want to delete "' + bookTitle + '"?\n\nThis action cannot be undone!')) {
        window.location.href = '<?= BASE_URL ?>?route=books/delete&id=' + bookId;
    }
}

// Category filter scroll functionality
document.addEventListener('DOMContentLoaded', function() {
    const filterContainer = document.getElementById('categoryFilters');
    const scrollLeft = document.getElementById('scrollLeft');
    const scrollRight = document.getElementById('scrollRight');

    if (filterContainer && scrollLeft && scrollRight) {
        // Check if scrollable
        function updateScrollIndicators() {
            const isScrollable = filterContainer.scrollWidth > filterContainer.clientWidth;
            const atStart = filterContainer.scrollLeft === 0;
            const atEnd = filterContainer.scrollLeft + filterContainer.clientWidth >= filterContainer.scrollWidth - 5;

            scrollLeft.style.display = isScrollable && !atStart ? 'flex' : 'none';
            scrollRight.style.display = isScrollable && !atEnd ? 'flex' : 'none';
        }

        // Scroll buttons
        scrollLeft.addEventListener('click', () => {
            filterContainer.scrollBy({ left: -200, behavior: 'smooth' });
        });

        scrollRight.addEventListener('click', () => {
            filterContainer.scrollBy({ left: 200, behavior: 'smooth' });
        });

        // Update on scroll
        filterContainer.addEventListener('scroll', updateScrollIndicators);
        window.addEventListener('resize', updateScrollIndicators);

        // Initial check
        updateScrollIndicators();
    }
});

// Modern UI Pagination
const BOOKS_PER_PAGE = 10;

function setupPaginationUI() {
    const books = Array.from(document.querySelectorAll('.book-card'))
        .filter(card => card.style.display !== 'none');
    const totalBooks = books.length;
    const totalPages = Math.ceil(totalBooks / BOOKS_PER_PAGE);

    let currentPage = window.__currentBookPage || 1;
    if (currentPage > totalPages) currentPage = totalPages;
    if (currentPage < 1) currentPage = 1;
    window.__currentBookPage = currentPage;

    function showPage(page) {
        if (page < 1) page = 1;
        if (page > totalPages) page = totalPages;
        window.__currentBookPage = page;

        books.forEach((book, idx) => {
            book.style.display = (idx >= (page-1)*BOOKS_PER_PAGE && idx < page*BOOKS_PER_PAGE) ? '' : 'none';
        });

        // Render pagination controls
        const pagination = document.getElementById('paginationControls');
        pagination.innerHTML = '';

        if (totalPages > 1) {
            // Prev button
            if (page > 1) {
                const prevBtn = document.createElement('button');
                prevBtn.className = "modern-pagination-btn";
                prevBtn.innerHTML = '<i class="bi bi-arrow-left"></i> <span class="d-none d-md-inline">Prev</span>';
                prevBtn.onclick = () => showPage(page - 1);
                pagination.appendChild(prevBtn);
            }

            // Page info
            const pageInfo = document.createElement('span');
            pageInfo.className = "modern-pagination-info";
            pageInfo.innerHTML = `Page <strong>${page}</strong> of <strong>${totalPages}</strong>`;
            pagination.appendChild(pageInfo);

            // Next button
            if (page < totalPages) {
                const nextBtn = document.createElement('button');
                nextBtn.className = "modern-pagination-btn";
                nextBtn.innerHTML = '<span class="d-none d-md-inline">Next</span> <i class="bi bi-arrow-right"></i>';
                nextBtn.onclick = () => showPage(page + 1);
                pagination.appendChild(nextBtn);
            }
        }

        // Update results count
        const resultsCount = document.getElementById('resultsCount');
        if (resultsCount) {
            resultsCount.innerHTML = `
                <i class="bi bi-info-circle me-1"></i>
                Showing <strong>${Math.min(BOOKS_PER_PAGE, totalBooks - (page-1)*BOOKS_PER_PAGE)}</strong>
                ${Math.min(BOOKS_PER_PAGE, totalBooks - (page-1)*BOOKS_PER_PAGE) === 1 ? 'book' : 'books'}
                <?= $current_category ? 'in <strong>' . htmlspecialchars($current_category) . '</strong>' : '' ?>
            `;
        }
    }

    showPage(currentPage);
    window.showBookPage = showPage;
}

document.addEventListener('DOMContentLoaded', setupPaginationUI);
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
   CATEGORY FILTERS - IMPROVED
   ============================================ */
.category-filters-wrapper {
    position: relative;
}

.category-filters {
    display: flex;
    flex-wrap: nowrap;
    gap: 0.5rem;
    overflow-x: auto;
    overflow-y: hidden;
    padding: 0.5rem 0;
    margin: 0;
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none; /* IE/Edge */
    scroll-behavior: smooth;
}

.category-filters::-webkit-scrollbar {
    display: none; /* Chrome/Safari */
}

/* Category badge styling */
.category-badge {
    flex-shrink: 0;
    white-space: nowrap;
    border-radius: 20px;
    padding: 0.5rem 1rem;
    background: var(--bg-muted);
    color: var(--text);
    font-weight: 500;
    font-size: 0.875rem;
    text-decoration: none;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    border: 2px solid transparent;
    transition: all 0.2s ease;
    display: inline-block;
}

.category-badge:hover {
    background: var(--primary);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.category-badge.active {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
    font-weight: 600;
}

/* Scroll indicators */
.scroll-indicator {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 32px;
    height: 32px;
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 50%;
    display: none;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 10;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    transition: all 0.2s ease;
}

.scroll-indicator:hover {
    background: var(--primary);
    color: white;
    transform: translateY(-50%) scale(1.1);
}

.scroll-left {
    left: -12px;
}

.scroll-right {
    right: -12px;
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
    transform: translateY(-4px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.15);
}

/* Book Card Image */
.book-card-image {
    width: 100%;
    height: 160px;
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
}

/* Book Title - FIXED FOR LONG TITLES */
.book-title {
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--text);
    margin-bottom: 0.5rem;
    line-height: 1.3;
    /* Multi-line ellipsis */
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    word-break: break-word;
    min-height: 2.6em; /* Reserve space for 2 lines */
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
}

.btn-soft-primary {
    background: #eaf2ff !important;
    color: var(--text) !important;
}
.btn-soft-secondary {
    background: var(--muted-bg) !important;
    color: var(--text) !important;
}
.btn-soft-warning {
    background: #fff7e7 !important;
    color: #a67c00 !important;
}
.btn-soft-danger {
    background: #ffebeb !important;
    color: #d90429 !important;
}
.btn-favorite.favorited {
    color: #ef4444 !important;
    font-weight: 600;
}

/* Pagination */
.modern-pagination-controls {
    position: fixed;
    right: 2rem;
    bottom: 2rem;
    z-index: 99;
    display: flex;
    gap: 0.5rem;
    align-items: center;
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    padding: 0.75rem 1rem;
}

.modern-pagination-btn {
    border: none;
    background: var(--primary);
    color: white;
    border-radius: 8px;
    padding: 0.5rem 1rem;
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.modern-pagination-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.modern-pagination-info {
    font-weight: 500;
    color: var(--text);
    margin: 0 0.5rem;
    font-size: 0.875rem;
}

/* ============================================
   MOBILE RESPONSIVE - IMPROVED
   ============================================ */
@media (max-width: 768px) {
    .category-filters {
        padding: 0.75rem 0;
        gap: 0.5rem;
    }

    .category-badge {
        font-size: 0.8rem;
        padding: 0.4rem 0.9rem;
    }

    .scroll-indicator {
        width: 28px;
        height: 28px;
        font-size: 0.875rem;
    }

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
        margin-bottom: 0.5rem;
    }

    .book-category {
        font-size: 0.7rem;
        padding: 0.2rem 0.4rem;
    }

    .book-card .btn {
        font-size: 0.8rem;
        padding: 0.5rem;
        margin-bottom: 0.3rem;
    }

    .modern-pagination-controls {
        right: 1rem;
        bottom: 1rem;
        padding: 0.5rem 0.75rem;
    }

    .modern-pagination-btn {
        padding: 0.4rem 0.8rem;
        font-size: 0.8rem;
    }

    .modern-pagination-info {
        font-size: 0.75rem;
    }
}

/* Dark theme adjustments */
body.dark-theme .category-badge {
    box-shadow: 0 1px 3px rgba(0,0,0,0.3);
}

body.dark-theme .scroll-indicator {
    box-shadow: 0 2px 8px rgba(0,0,0,0.4);
}

body.dark-theme .book-card {
    box-shadow: 0 1px 3px rgba(0,0,0,0.3);
}

body.dark-theme .book-card:hover {
    box-shadow: 0 8px 16px rgba(0,0,0,0.4);
}
</style>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
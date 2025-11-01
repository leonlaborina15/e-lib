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
<div class="category-filters mb-4">
    <a href="<?= BASE_URL ?>?route=books"
       class="btn <?= !$current_category ? 'active' : '' ?>">
        All Categories
    </a>
    <?php foreach ($categories as $cat): ?>
        <a href="<?= BASE_URL ?>?route=books&category=<?= urlencode($cat) ?>"
           class="btn <?= $current_category === $cat ? 'active' : '' ?>">
            <?= htmlspecialchars($cat) ?>
        </a>
    <?php endforeach; ?>
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

// Modern UI Pagination
const BOOKS_PER_PAGE = 10;

function setupPaginationUI() {
    const books = Array.from(document.querySelectorAll('.book-card'))
        .filter(card => card.style.display !== 'none'); // Only visible books
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

    // Save current page in window for persistence between search/pagination
    window.showBookPage = showPage;
}

document.addEventListener('DOMContentLoaded', setupPaginationUI);
</script>

<style>
:root {
    --primary: #23272f;
    --card-bg: #fff;
    --soft-bg: #f6f8fa;
    --border: #e6e8ec;
    --muted-bg: #f3f4f6;
    --secondary: #7b8191;
}

/* Category Filters - Modern, Scrollable, Responsive */
.category-filters {
    display: flex;
    flex-wrap: nowrap;
    gap: 0.5rem;
    overflow-x: auto;
    padding-bottom: 0.3rem;
    margin-bottom: 1.2rem;
    scrollbar-width: thin;       /* Firefox */
    scrollbar-color: #eaf2ff #fff;
}

.category-filters::-webkit-scrollbar {
    height: 6px;
    background: #fff;
}

.category-filters::-webkit-scrollbar-thumb {
    background: #eaf2ff;
    border-radius: 20px;
}

/* Modern pill style for category badges */
.category-filters a.btn {
    white-space: nowrap;
    border-radius: 999px;
    padding: 0.28em 1.15em;
    background: #f5f7fa;
    color: #23272f;
    font-weight: 500;
    font-size: 1rem;
    box-shadow: 0 1px 6px rgba(30,30,30,0.04);
    border: 1.5px solid transparent;
    transition: background 0.15s, color 0.15s, border 0.15s;
}

.category-filters a.btn.active,
.category-filters a.btn:hover {
    background: #eaf2ff;
    color: #2153ff;
    border: 1.5px solid #2153ff;
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
.btn-soft-secondary {
    background: var(--muted-bg) !important;
    color: var(--primary) !important;
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

/* Modern Pagination Styles */
.modern-pagination-controls {
    position: fixed;
    right: 32px;
    bottom: 32px;
    z-index: 99;
    display: flex;
    gap: 0.4rem;
    align-items: center;
    background: rgba(255,255,255,0.9);
    border-radius: 16px;
    box-shadow: 0 4px 16px rgba(30,30,30,0.18);
    padding: 0.6rem 1.3rem;
    font-size: 1.08rem;
}

.modern-pagination-btn {
    border: none;
    background: #eaf2ff;
    color: var(--primary);
    border-radius: 999px;
    padding: 0.46rem 1.15rem;
    font-weight: 600;
    font-size: 1.06rem;
    box-shadow: 0 1px 6px rgba(30,30,30,0.07);
    cursor: pointer;
    transition: background 0.15s, box-shadow 0.17s;
    display: flex;
    align-items: center;
    gap: 0.4em;
}
.modern-pagination-btn:hover {
    background: #d2e5ff;
    box-shadow: 0 4px 16px rgba(30,30,30,0.16);
}

.modern-pagination-info {
    font-weight: 500;
    color: var(--primary);
    margin: 0 0.6rem;
}

@media (max-width: 768px) {
    .books-grid {
        grid-template-columns: 1fr;
        gap: 0.7rem;
    }
    .book-card {
        display: flex;
        flex-direction: row;
        align-items: stretch;
        min-height: 230px;
        height: 230px;
        padding: 0;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 1px 4px rgba(30,30,30,0.05);
        background: var(--card-bg);
    }
    .book-card-image {
        width: 40%;
        height: 100%;
        margin: 0;
        border-radius: 24px 0 0 24px;
        overflow: hidden;
        display: flex;
        align-items: stretch;
        justify-content: stretch;
        background: var(--muted-bg);
        position: relative;
        min-width: 0;
    }
    .book-card-image img,
    .book-card-image > div {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .book-card-body {
        width: 60%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 1.1rem 1rem;
        min-width: 0;
    }
    .book-title, .book-author, .book-category {
        white-space: normal;
        overflow: visible;
        text-overflow: unset;
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
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.55em;
        text-align: center;
    }
    .modern-pagination-controls {
        right: 12px;
        bottom: 12px;
        padding: 0.5rem 0.6rem;
        font-size: 1.01rem;
    }
    .modern-pagination-btn {
        padding: 0.38rem 0.7rem;
        font-size: 1.01rem;
    }
}



</style>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
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
.form-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    border: 1px solid #f0f0f0;
    max-width: 950px;
    margin: 0 auto;
}

.form-header {
    background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%);
    border-radius: 12px;
    padding: 1.5rem;
    color: white;
    margin-bottom: 2rem;
    text-align: center;
}

.book-entry-form {
    background: #f6f8fa;
    border-radius: 12px;
    padding: 1.2rem 1.5rem;
    margin-bottom: 2rem;
    border: 1px solid #e2e8f0;
    box-shadow: 0 1px 4px rgba(30,30,30,0.05);
    position: relative;
}
.book-entry-form .remove-book-btn {
    position: absolute;
    top: 1rem;
    right: 1rem;
    z-index: 2;
}

.form-group-modern label {
    font-size: 0.875rem;
    font-weight: 600;
    color: #4a5568;
    margin-bottom: 0.5rem;
}

.form-group-modern input,
.form-group-modern textarea {
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    padding: 0.75rem 1rem;
    transition: all 0.2s ease;
}

.form-group-modern input:focus,
.form-group-modern textarea:focus {
    border-color: #0066cc;
    box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.1);
}

.file-preview {
    border-radius: 8px;
    border: 2px dashed #e2e8f0;
    padding: 1rem;
    text-align: center;
    background: #f8f9fa;
    margin-top: 0.75rem;
}

.file-preview img {
    max-width: 100%;
    max-height: 200px;
    border-radius: 8px;
}

/* Add another book button */
#addBookBtn {
    margin-bottom: 2rem;
}

hr.hr-book {
    margin: 2.5rem 0 2rem 0;
    border-color: #e2e8f0;
}
</style>

<div class="mb-3">
    <a href="<?= BASE_URL ?>?route=books" class="btn btn-soft-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back to Books
    </a>
</div>

<div class="form-card">
    <!-- Header -->
    <div class="form-header">
        <h3 class="mb-0 text-white">
            <i class="bi bi-plus-circle me-2"></i>
            Add Multiple Books
        </h3>
        <p class="mb-0 mt-2 text-white" style="opacity: 0.9;">Fill in details for each book below</p>
    </div>

    <form method="POST" enctype="multipart/form-data" class="needs-validation" id="multiBooksForm" novalidate>
        <div id="bookFormsContainer">
            <!-- Single Book Entry Form (template) -->
            <div class="book-entry-form">
                <button type="button" class="btn btn-soft-danger btn-sm remove-book-btn" onclick="removeBookForm(this)" style="display:none;">
                    <i class="bi bi-trash"></i>
                </button>
                <div class="row g-3 mb-0">
                    <div class="col-md-6 form-group-modern">
                        <label>
                            <i class="bi bi-book me-1"></i>Book Title <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" name="title[]" required placeholder="Enter book title">
                        <div class="invalid-feedback">Please enter the book title.</div>
                    </div>
                    <div class="col-md-6 form-group-modern">
                        <label>
                            <i class="bi bi-person me-1"></i>Author <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" name="author[]" required placeholder="Enter author name">
                        <div class="invalid-feedback">Please enter the author name.</div>
                    </div>
                    <div class="col-md-6 form-group-modern">
                        <label>
                            <i class="bi bi-tag me-1"></i>Category
                        </label>
                        <input type="text" class="form-control" name="category[]" placeholder="e.g., Fiction, Science, History" list="categoryList">
                        <datalist id="categoryList">
                            <option value="Fiction">
                            <option value="Non-Fiction">
                            <option value="Science">
                            <option value="Technology">
                            <option value="History">
                            <option value="Biography">
                            <option value="Self-Help">
                            <option value="Education">
                            <option value="Children">
                            <option value="Romance">
                            <option value="Mystery">
                            <option value="Fantasy">
                        </datalist>
                    </div>
                    <div class="col-md-6 form-group-modern">
                        <label>
                            <i class="bi bi-building me-1"></i>Publisher
                        </label>
                        <input type="text" class="form-control" name="publisher[]" placeholder="Enter publisher name">
                    </div>
                    <div class="col-md-6 form-group-modern">
                        <label>
                            <i class="bi bi-calendar-event me-1"></i>Published Year
                        </label>
                        <input type="number" class="form-control" name="published_year[]" min="1000" max="<?= date('Y') ?>" placeholder="<?= date('Y') ?>">
                        <small class="text-muted">Between 1000 and <?= date('Y') ?></small>
                    </div>
                    <div class="col-12 form-group-modern">
                        <label>
                            <i class="bi bi-file-text me-1"></i>Description
                        </label>
                        <textarea class="form-control" name="description[]" rows="3" placeholder="Enter book description, summary, or additional details..."></textarea>
                        <small class="text-muted">Optional: Brief summary or description of the book</small>
                    </div>
                    <div class="col-md-6 form-group-modern">
                        <label>
                            <i class="bi bi-image me-1"></i>Cover Image
                        </label>
                        <input type="file" class="form-control" name="cover_image[]" accept="image/jpeg,image/png,image/jpg,image/gif">
                        <small class="text-muted d-block mt-1">Accepted: JPG, PNG, GIF (Max 2MB)</small>
                    </div>
                    <div class="col-md-6 form-group-modern">
                        <label>
                            <i class="bi bi-file-pdf me-1"></i>PDF File
                        </label>
                        <input type="file" class="form-control" name="pdf_file[]" accept=".pdf,application/pdf">
                        <small class="text-muted d-block mt-1">Upload the book PDF file (Max 50MB)</small>
                    </div>
                </div>
            </div>
        </div>

        <button type="button" id="addBookBtn" class="btn btn-soft-primary">
            <i class="bi bi-plus me-1"></i> Add Another Book
        </button>

        <hr class="hr-book">

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-soft-primary btn-lg">
                <i class="bi bi-plus-circle me-2"></i>
                Add All Books
            </button>
            <a href="<?= BASE_URL ?>?route=books" class="btn btn-soft-secondary btn-lg">
                <i class="bi bi-x-circle me-2"></i>
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
// Add another book entry form
document.getElementById('addBookBtn').onclick = function() {
    const container = document.getElementById('bookFormsContainer');
    const forms = container.querySelectorAll('.book-entry-form');
    const clone = forms[0].cloneNode(true);

    // Clear input values
    clone.querySelectorAll('input, textarea').forEach(el => {
        if (el.type === 'file') {
            el.value = '';
        } else {
            el.value = '';
        }
    });
    // Show remove button on all but first
    clone.querySelector('.remove-book-btn').style.display = 'block';
    container.appendChild(clone);
};

// Remove a book entry form
function removeBookForm(btn) {
    btn.closest('.book-entry-form').remove();
}

// Form validation
(function () {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
})();
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
<?php
/**
 * Edit Book View - Modern Soft Design
 * Last Updated: 2025-10-29 03:08:28 UTC
 * Author: leonlaborina15
 */
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/sidebar.php';
?>

<style>
.form-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    border: 1px solid #f0f0f0;
    max-width: 900px;
    margin: 0 auto;
}

.form-header {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    border-radius: 12px;
    padding: 1.5rem;
    color: white;
    margin-bottom: 2rem;
    text-align: center;
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
    border-color: #fbbf24;
    box-shadow: 0 0 0 3px rgba(251, 191, 36, 0.1);
}

.file-preview {
    border-radius: 8px;
    border: 2px dashed #e2e8f0;
    padding: 1rem;
    text-align: center;
    background: #f8f9fa;
}

.current-file-badge {
    background: #f0fff4;
    border: 1px solid #86efac;
    border-radius: 8px;
    padding: 0.75rem;
    margin-bottom: 0.75rem;
}
</style>

<!-- Back Button -->
<div class="mb-3">
    <a href="<?= BASE_URL ?>?route=books/show&id=<?= $book['id'] ?>" class="btn btn-soft-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back to Book
    </a>
</div>

<div class="form-card">
    <!-- Header -->
    <div class="form-header">
    <h3 class="mb-0 text-white">
        <i class="bi bi-pencil-square me-2"></i>
        Edit Book
    </h3>
    <p class="mb-0 mt-2 text-white" style="opacity:0.9;">Update book information and files</p>
</div>
    <form method="POST" enctype="multipart/form-data">
        <!-- Basic Information -->
        <h5 class="mb-3">
            <i class="bi bi-info-circle text-primary me-2"></i>
            Basic Information
        </h5>

        <div class="row g-3 mb-4">
            <div class="col-md-6 form-group-modern">
                <label for="title">
                    <i class="bi bi-book me-1"></i>Book Title *
                </label>
                <input type="text"
                       class="form-control"
                       id="title"
                       name="title"
                       value="<?= htmlspecialchars($book['title']) ?>"
                       required>
            </div>

            <div class="col-md-6 form-group-modern">
                <label for="author">
                    <i class="bi bi-person me-1"></i>Author *
                </label>
                <input type="text"
                       class="form-control"
                       id="author"
                       name="author"
                       value="<?= htmlspecialchars($book['author']) ?>"
                       required>
            </div>

          

            <div class="col-md-6 form-group-modern">
                <label for="category">
                    <i class="bi bi-tag me-1"></i>Category
                </label>
                <input type="text"
                       class="form-control"
                       id="category"
                       name="category"
                       value="<?= htmlspecialchars($book['category'] ?? '') ?>"
                       placeholder="e.g., Fiction, Science"
                       list="categoryList">
                <datalist id="categoryList">
                    <option value="Fiction">
                    <option value="Non-Fiction">
                    <option value="Science">
                    <option value="Technology">
                    <option value="History">
                    <option value="Biography">
                </datalist>
            </div>

            <div class="col-md-6 form-group-modern">
                <label for="publisher">
                    <i class="bi bi-building me-1"></i>Publisher
                </label>
                <input type="text"
                       class="form-control"
                       id="publisher"
                       name="publisher"
                       value="<?= htmlspecialchars($book['publisher'] ?? '') ?>">
            </div>

            <div class="col-md-6 form-group-modern">
                <label for="published_year">
                    <i class="bi bi-calendar-event me-1"></i>Published Year
                </label>
                <input type="number"
                       class="form-control"
                       id="published_year"
                       name="published_year"
                       value="<?= htmlspecialchars($book['published_year'] ?? '') ?>"
                       min="1000"
                       max="<?= date('Y') ?>">
            </div>

            <div class="col-12 form-group-modern">
                <label for="description">
                    <i class="bi bi-file-text me-1"></i>Description
                </label>
                <textarea class="form-control"
                          id="description"
                          name="description"
                          rows="4"
                          placeholder="Enter book description..."><?= htmlspecialchars($book['description'] ?? '') ?></textarea>
            </div>
        </div>

        <hr class="my-4">

        <!-- File Uploads -->
        <h5 class="mb-3">
            <i class="bi bi-cloud-upload text-primary me-2"></i>
            Files
        </h5>

        <div class="row g-3 mb-4">
            <!-- Cover Image -->
            <div class="col-md-6 form-group-modern">
                <label for="cover_image">
                    <i class="bi bi-image me-1"></i>Cover Image
                </label>

                <?php if ($book['cover_image']): ?>
                <div class="current-file-badge">
                    <img src="<?= BASE_URL ?>uploads/covers/<?= $book['cover_image'] ?>"
                         alt="Current cover"
                         class="img-thumbnail mb-2"
                         style="max-height: 150px;">
                    <p class="text-success mb-0">
                        <i class="bi bi-check-circle me-1"></i>
                        <small>Current cover image</small>
                    </p>
                </div>
                <?php endif; ?>

                <input type="file"
                       class="form-control"
                       id="cover_image"
                       name="cover_image"
                       accept="image/*"
                       onchange="previewImage(this)">
                <small class="text-muted">Upload new image to replace (Max 2MB)</small>

                <div id="imagePreview" class="file-preview mt-2" style="display: none;">
                    <img id="previewImg" src="" alt="Preview" style="max-height: 150px;">
                    <p class="text-muted mb-0 mt-2"><small>New image preview</small></p>
                </div>
            </div>

            <!-- PDF File -->
            <div class="col-md-6 form-group-modern">
                <label for="pdf_file">
                    <i class="bi bi-file-pdf me-1"></i>PDF File
                </label>

                <?php if ($book['pdf_file']): ?>
                <div class="current-file-badge">
                    <i class="bi bi-file-pdf-fill text-danger" style="font-size: 2rem;"></i>
                    <p class="text-success mb-0 mt-2">
                        <i class="bi bi-check-circle me-1"></i>
                        <small><?= htmlspecialchars($book['pdf_file']) ?></small>
                    </p>
                </div>
                <?php endif; ?>

                <input type="file"
                       class="form-control"
                       id="pdf_file"
                       name="pdf_file"
                       accept=".pdf"
                       onchange="showFileName(this)">
                <small class="text-muted">Upload new PDF to replace (Max 50MB)</small>

                <div id="pdfFileName" class="file-preview mt-2" style="display: none;">
                    <i class="bi bi-file-pdf-fill text-danger" style="font-size: 2rem;"></i>
                    <p class="text-muted mb-0 mt-2">
                        <small id="fileName"></small>
                    </p>
                </div>
            </div>
        </div>

        <hr class="my-4">

        <!-- Action Buttons -->
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-soft-warning btn-lg">
                <i class="bi bi-save me-2"></i> Update Book
            </button>
            <a href="<?= BASE_URL ?>?route=books/show&id=<?= $book['id'] ?>"
               class="btn btn-soft-secondary btn-lg">
                <i class="bi bi-x-circle me-2"></i> Cancel
            </a>
        </div>
    </form>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.style.display = 'none';
    }
}

function showFileName(input) {
    const fileNameDiv = document.getElementById('pdfFileName');
    const fileNameSpan = document.getElementById('fileName');

    if (input.files && input.files[0]) {
        fileNameSpan.textContent = input.files[0].name;
        fileNameDiv.style.display = 'block';
    } else {
        fileNameDiv.style.display = 'none';
    }
}
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
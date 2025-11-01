<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<div class="section-card" style="max-width: 500px; margin: 2rem auto;">
    <h5>Leave a Website Review</h5>
    <form method="POST" action="/?route=reviews/store">
        <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?? 0 ?>">
        <div class="mb-2">
            <label>Your Name:</label>
            <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($_SESSION['name'] ?? '') ?>">
        </div>
        <div class="mb-2">
            <label>Rating:</label>
            <select name="rating" class="form-control" required>
                <option value="">Rate us</option>
                <?php for ($i=5; $i>=1; $i--): ?>
                    <option value="<?= $i ?>"><?= $i ?> Star<?= $i>1?'s':'' ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="mb-2">
            <label>Your Review:</label>
            <textarea name="review_text" class="form-control" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Submit Review</button>
    </form>
</div>

<div class="section-card" style="max-width:600px;margin:2rem auto;">
    <h5>What Our Users Say</h5>
    <?php if (!empty($reviews)): ?>
        <?php foreach ($reviews as $row): ?>
            <div style="border-bottom:1px solid #eee;padding:1rem 0;">
                <strong><?= htmlspecialchars($row['name']) ?></strong>
                <span style="color:gold;">
                    <?= str_repeat('★', $row['rating']) ?><?= str_repeat('☆', 5 - $row['rating']) ?>
                </span>
                <div><?= nl2br(htmlspecialchars($row['review_text'])) ?></div>
                <small class="text-muted"><?= date('M d, Y', strtotime($row['created_at'])) ?></small>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="text-muted">No reviews yet. Be the first!</div>
    <?php endif; ?>
</div>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
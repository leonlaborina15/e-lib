<?php $page_title = 'Borrow Records'; ?>
<?php require_once BASE_PATH . '/app/views/layouts/header.php'; ?>
<?php require_once BASE_PATH . '/app/views/layouts/navbar.php'; ?>

<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-white">
            <h4><i class="bi bi-arrow-left-right"></i> Borrow Records</h4>
        </div>
        <div class="card-body">
            <?php if (empty($records)): ?>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> No borrow records found.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'librarian'): ?>
                                    <th>User</th>
                                <?php endif; ?>
                                <th>Book Title</th>
                                <th>Author</th>
                                <th>Borrow Date</th>
                                <th>Return Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($records as $record): ?>
                                <tr>
                                    <td><?= $record['id'] ?></td>
                                    <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'librarian'): ?>
                                        <td><?= htmlspecialchars($record['user_name'] ?? $record['email']) ?></td>
                                    <?php endif; ?>
                                    <td><?= htmlspecialchars($record['title']) ?></td>
                                    <td><?= htmlspecialchars($record['author']) ?></td>
                                    <td><?= date('M d, Y', strtotime($record['borrow_date'])) ?></td>
                                    <td>
                                        <?= $record['return_date'] ? date('M d, Y', strtotime($record['return_date'])) : '-' ?>
                                    </td>
                                    <td>
                                        <span class="badge <?= $record['status'] === 'borrowed' ? 'bg-warning' : 'bg-success' ?>">
                                            <?= ucfirst($record['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($record['status'] === 'borrowed'): ?>
                                            <button class="btn btn-sm btn-primary" onclick="returnBook(<?= $record['id'] ?>)">
                                                <i class="bi bi-check-circle"></i> Return
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once BASE_PATH . '/app/views/layouts/footer.php'; ?>
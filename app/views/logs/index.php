<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<?php
// --- PAGINATION LOGIC ---
$logsPerPage = 10;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $logsPerPage;

$pagedLogs = array_slice($logs, $offset, $logsPerPage);

$totalLogs = count($logs);
$totalPages = ceil($totalLogs / $logsPerPage);

$routeName = isset($_GET['route']) ? htmlspecialchars($_GET['route']) : 'activity-logs';
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

.container-fluid {
    padding-top: 0.2rem !important;
}

.card {
    margin-top: 0 !important;
    margin-bottom: 1rem !important;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    border-radius: 12px;
    border: 1px solid var(--border);
    max-width: 900px;
    margin-left: auto;
    margin-right: auto;
    background: #fff;
}
.card-header.bg-grey {
    background: #374151 !important;
    color: #fff !important;
    padding: 0.7rem 1.2rem !important;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
}
.card-body {
    padding: 0.7rem 1.2rem !important;
    border-bottom-left-radius: 12px;
    border-bottom-right-radius: 12px;
    background: var(--card-bg);
}

.table-responsive {
    margin-bottom: 0.5rem !important;
    width: 100%;
    overflow-x: auto;
}
.table th, .table td {
    padding: 0.55rem 0.8rem !important;
    font-size: 1.05rem;
    vertical-align: middle !important;
    white-space: nowrap;
}
.table thead {
    background: var(--muted-bg);
}
.badge.timestamp-badge {
    background: #374151 !important;
    color: #fff !important;
    font-size: 0.95rem;
    border-radius: 8px;
    padding: 0.4em 0.9em;
    font-weight: 500;
    letter-spacing: 0.02em;
}

.logs-pagination {
    margin-top: 0.7rem;
    padding-top: 0.4rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 1px solid var(--border);
}
.logs-pagination .btn {
    min-width: 78px;
    font-size: 1rem;
    padding: 0.4rem 1.1rem;
}
.logs-pagination .page-info {
    color: var(--secondary);
    font-size: 0.98rem;
}

.btn-outline-secondary {
    font-size: 0.97rem;
    padding: 0.4rem 1rem;
    margin-right: 0.7rem;
}

/* MOBILE RESPONSIVE STYLES */
@media (max-width: 576px) {
    .card {
        max-width: 100%;
        border-radius: 8px;
        margin-left: 0;
        margin-right: 0;
    }
    .card-header.bg-grey {
        font-size: 1rem;
        padding: 0.6rem 0.7rem !important;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }
    .card-body {
        padding: 0.6rem 0.7rem !important;
        border-bottom-left-radius: 8px;
        border-bottom-right-radius: 8px;
    }
    .table th, .table td {
        padding: 0.4rem 0.4rem !important;
        font-size: 0.92rem;
    }
    .logs-pagination {
        flex-direction: column;
        align-items: stretch;
        gap: 0.7rem;
        margin-top: 0.5rem;
        padding-top: 0.3rem;
    }
    .logs-pagination .btn {
        width: 100%;
        min-width: unset;
        margin-bottom: 0.4rem;
        font-size: 1rem;
    }
    .logs-pagination .page-info {
        text-align: right;
        font-size: 0.95rem;
        margin-top: 0.1rem;
        margin-bottom: 0.1rem;
    }
    .btn-outline-secondary {
        width: 100%;
        margin-right: 0;
        margin-bottom: 0.4rem;
    }
}
</style>

<div class="container-fluid">
    <div class="row" style="margin-top:0;">
        <div class="col-12" style="margin-top:0;">
            <div class="card" id="activity-logs-card">
                <div class="card-header bg-grey">
                    <h4 class="mb-0 text-white" style="font-size:1.15rem;">
                        <i class="bi bi-activity"></i> Activity Logs
                    </h4>
                </div>
                <div class="card-body">
                    <?php if (empty($pagedLogs)): ?>
                        <div class="alert alert-info text-center">
                            <i class="bi bi-info-circle"></i>
                            <p class="mt-2 mb-0">No activity logs yet.</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><i class="bi bi-person"></i> User</th>
                                        <th><i class="bi bi-envelope"></i> Email</th>
                                        <th><i class="bi bi-lightning"></i> Action</th>
                                        <th><i class="bi bi-clock"></i> Timestamp</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pagedLogs as $index => $log): ?>
                                        <tr>
                                            <td><?= $offset + $index + 1 ?></td>
                                            <td>
                                                <strong><?= htmlspecialchars($log['user_name']) ?></strong>
                                            </td>
                                            <td>
                                                <small class="text-muted"><?= htmlspecialchars($log['email']) ?></small>
                                            </td>
                                            <td>
                                                <?php
                                                $action = $log['action'];
                                                if (stripos($action, 'login') !== false) {
                                                    echo '<i class="bi bi-box-arrow-in-right text-success"></i> ';
                                                } elseif (stripos($action, 'logout') !== false) {
                                                    echo '<i class="bi bi-box-arrow-right text-warning"></i> ';
                                                } elseif (stripos($action, 'added') !== false || stripos($action, 'created') !== false) {
                                                    echo '<i class="bi bi-plus-circle text-success"></i> ';
                                                } elseif (stripos($action, 'deleted') !== false) {
                                                    echo '<i class="bi bi-trash text-danger"></i> ';
                                                } elseif (stripos($action, 'updated') !== false || stripos($action, 'edited') !== false) {
                                                    echo '<i class="bi bi-pencil text-primary"></i> ';
                                                } elseif (stripos($action, 'favorite') !== false) {
                                                    echo '<i class="bi bi-heart-fill text-danger"></i> ';
                                                } elseif (stripos($action, 'read') !== false || stripos($action, 'download') !== false) {
                                                    echo '<i class="bi bi-book text-info"></i> ';
                                                } else {
                                                    echo '<i class="bi bi-activity text-secondary"></i> ';
                                                }
                                                echo htmlspecialchars($action);
                                                ?>
                                            </td>
                                            <td>
                                                <span class="badge timestamp-badge">
                                                    <?= date('M d, Y H:i:s', strtotime($log['timestamp'])) ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <p class="text-muted mb-0" style="font-size:0.97rem;">
                            <i class="bi bi-info-circle"></i>
                            Showing <?= count($pagedLogs) ?> of <?= $totalLogs ?> activity logs
                        </p>
                    <?php endif; ?>

                    <div class="logs-pagination">
                        <a href="<?= BASE_URL ?>?route=dashboard" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Dashboard
                        </a>
                        <div>
                            <?php if ($page > 1): ?>
                                <a href="?route=<?= $routeName ?>&page=<?= $page - 1 ?>" class="btn btn-outline-primary">
                                    &larr; Prev
                                </a>
                            <?php endif; ?>
                            <?php if ($page < $totalPages): ?>
                                <a href="?route=<?= $routeName ?>&page=<?= $page + 1 ?>" class="btn btn-outline-primary">
                                    Next &rarr;
                                </a>
                            <?php endif; ?>
                            <span class="page-info">Page <?= $page ?> of <?= $totalPages ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
window.addEventListener('DOMContentLoaded', function() {
    if (window.location.search.includes('page=')) {
        var card = document.getElementById('activity-logs-card');
        if(card){
            card.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }
});
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
<?php
$pageTitle = 'Trainings - WAMDEVIN Admin';
$pageDescription = 'Deliver leadership development programmes that scale institutional capability';
$currentPage = 'trainings';
$useCalendar = false;
$useCharts = false;
$useCounter = false;
$includeLegacyCSS = true;
$includeLegacyJS = true;

include('includes/admin-header.php');
include('includes/admin-sidebar.php');

$db = getDashboardConnection();
$trainingRows = [];
$hasTrainingsTable = false;
$search = isset($_GET['q']) ? trim($_GET['q']) : '';
$statusFilter = isset($_GET['status']) ? trim($_GET['status']) : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 10;
$pagination = buildPagination(0, $page, $perPage);
if ($db && adminTableExists($db, 'trainings')) {
    $hasTrainingsTable = true;
    $where = [];
    $params = [];
    $titleExpr = adminColumnExists($db, 'trainings', 'title') ? 'title' : "CONCAT('Training #', id)";
    $startExpr = adminColumnExists($db, 'trainings', 'start_date') ? 'start_date' : 'NOW()';
    $endExpr = adminColumnExists($db, 'trainings', 'end_date') ? 'end_date' : 'NULL';
    $hasStatus = adminColumnExists($db, 'trainings', 'status');
    $statusExpr = $hasStatus ? 'status' : "'active'";

    if ($search !== '') {
        $where[] = "{$titleExpr} LIKE :q";
        $params[':q'] = '%' . $search . '%';
    }
    if ($statusFilter !== '' && $hasStatus) {
        $where[] = "status = :status";
        $params[':status'] = $statusFilter;
    }
    $whereSql = empty($where) ? '' : (' WHERE ' . implode(' AND ', $where));
    $total = (int)adminScalar($db, "SELECT COUNT(*) FROM trainings{$whereSql}", $params, 0);
    $pagination = buildPagination($total, $page, $perPage);
    $trainingRows = adminRows($db, "SELECT {$titleExpr} AS title, {$startExpr} AS start_date, {$endExpr} AS end_date, {$statusExpr} AS status FROM trainings{$whereSql} ORDER BY {$startExpr} DESC LIMIT {$pagination['offset']}, {$pagination['perPage']}", $params);
}
?>

<main class="ttr-wrapper" id="main-content" role="main">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Trainings</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
                <li>Trainings</li>
            </ul>
        </div>

        <?php include('includes/admin-page-intro.php'); ?>

        <div class="widget-box">
            <div class="wc-title">
                <h4>Training Programmes</h4>
            </div>
            <div class="widget-inner">
                <p>Deliver leadership development programmes that scale capability across member institutions.</p>
                <ul>
                    <li>Programme calendars and learning pathways</li>
                    <li>Facilitator assignments and quality assurance</li>
                    <li>Participant enrollment and outcomes tracking</li>
                </ul>
            </div>
        </div>

        <div class="widget-box m-t20">
            <div class="wc-title">
                <h4>Recent Training Programmes</h4>
            </div>
            <div class="widget-inner">
                <form method="get" class="form-inline m-b15" style="gap: 10px;">
                    <input type="text" name="q" class="form-control" placeholder="Search programme" value="<?php echo sanitizeOutput($search); ?>">
                    <select name="status" class="form-control">
                        <option value="">All Statuses</option>
                        <option value="active" <?php echo $statusFilter === 'active' ? 'selected' : ''; ?>>Active</option>
                        <option value="planned" <?php echo $statusFilter === 'planned' ? 'selected' : ''; ?>>Planned</option>
                        <option value="completed" <?php echo $statusFilter === 'completed' ? 'selected' : ''; ?>>Completed</option>
                        <option value="cancelled" <?php echo $statusFilter === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                    </select>
                    <button type="submit" class="btn button-sm green">Filter</button>
                </form>
                <?php if (!$hasTrainingsTable): ?>
                    <p class="wam-empty-text">Table trainings was not found in the current database.</p>
                <?php elseif (empty($trainingRows)): ?>
                    <p class="wam-empty-text">No training programmes found yet.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Programme</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($trainingRows as $training): ?>
                                <tr>
                                    <td><?php echo sanitizeOutput($training['title']); ?></td>
                                    <td><?php echo sanitizeOutput(date('M d, Y', strtotime($training['start_date']))); ?></td>
                                    <td><?php echo $training['end_date'] ? sanitizeOutput(date('M d, Y', strtotime($training['end_date']))) : '—'; ?></td>
                                    <td><span class="btn button-sm <?php echo getStatusButtonClass($training['status']); ?>"><?php echo sanitizeOutput($training['status']); ?></span></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if ($pagination['totalPages'] > 1): ?>
                        <div class="m-t15">
                            <?php if ($pagination['hasPrev']): ?><a class="btn button-sm outline" href="?q=<?php echo urlencode($search); ?>&status=<?php echo urlencode($statusFilter); ?>&page=<?php echo $pagination['prevPage']; ?>">Prev</a><?php endif; ?>
                            <span class="m-l10 m-r10">Page <?php echo $pagination['currentPage']; ?> of <?php echo $pagination['totalPages']; ?></span>
                            <?php if ($pagination['hasNext']): ?><a class="btn button-sm outline" href="?q=<?php echo urlencode($search); ?>&status=<?php echo urlencode($statusFilter); ?>&page=<?php echo $pagination['nextPage']; ?>">Next</a><?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php include('includes/admin-footer.php'); ?>

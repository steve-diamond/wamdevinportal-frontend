<?php
$pageTitle = 'Consultancy - WAMDEVIN Admin';
$pageDescription = 'Manage advisory engagements that translate strategy into outcomes';
$currentPage = 'consultancy';
$useCalendar = false;
$useCharts = false;
$useCounter = false;
$includeLegacyCSS = true;
$includeLegacyJS = true;

include('includes/admin-header.php');
include('includes/admin-sidebar.php');

$db = getDashboardConnection();
$consultancyRows = [];
$hasConsultancyTable = false;
$search = isset($_GET['q']) ? trim($_GET['q']) : '';
$statusFilter = isset($_GET['status']) ? trim($_GET['status']) : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 10;
$pagination = buildPagination(0, $page, $perPage);
if ($db && adminTableExists($db, 'consultancy_requests')) {
    $hasConsultancyTable = true;
    $where = [];
    $params = [];
    $orgExpr = adminColumnExists($db, 'consultancy_requests', 'organization_name') ? 'organization_name' : "'N/A'";
    $titleExpr = adminColumnExists($db, 'consultancy_requests', 'title') ? 'title' : "CONCAT('Request #', id)";
    $hasStatus = adminColumnExists($db, 'consultancy_requests', 'status');
    $statusExpr = $hasStatus ? 'status' : "'pending'";
    $dateExpr = adminColumnExists($db, 'consultancy_requests', 'created_at') ? 'created_at' : 'NOW()';
    if ($search !== '') {
        $where[] = "{$titleExpr} LIKE :q";
        $params[':q'] = '%' . $search . '%';
    }
    if ($statusFilter !== '' && $hasStatus) {
        $where[] = "status = :status";
        $params[':status'] = $statusFilter;
    }
    $whereSql = empty($where) ? '' : (' WHERE ' . implode(' AND ', $where));
    $total = (int)adminScalar($db, "SELECT COUNT(*) FROM consultancy_requests{$whereSql}", $params, 0);
    $pagination = buildPagination($total, $page, $perPage);
    $consultancyRows = adminRows($db, "SELECT {$titleExpr} AS title, {$orgExpr} AS organization_name, {$statusExpr} AS status, {$dateExpr} AS created_at FROM consultancy_requests{$whereSql} ORDER BY {$dateExpr} DESC LIMIT {$pagination['offset']}, {$pagination['perPage']}", $params);
}
?>

<main class="ttr-wrapper" id="main-content" role="main">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Consultancy</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
                <li>Consultancy</li>
            </ul>
        </div>

        <?php include('includes/admin-page-intro.php'); ?>

        <div class="widget-box">
            <div class="wc-title">
                <h4>Engagements & Requests</h4>
            </div>
            <div class="widget-inner">
                <p>Manage advisory engagements that translate strategy into measurable outcomes.</p>
                <ul>
                    <li>Intake and qualification of requests</li>
                    <li>Proposal pipeline and approvals</li>
                    <li>Delivery status, outcomes, and feedback</li>
                </ul>
            </div>
        </div>

        <div class="widget-box m-t20">
            <div class="wc-title">
                <h4>Recent Consultancy Requests</h4>
            </div>
            <div class="widget-inner">
                <form method="get" class="form-inline m-b15" style="gap: 10px;">
                    <input type="text" name="q" class="form-control" placeholder="Search request" value="<?php echo sanitizeOutput($search); ?>">
                    <select name="status" class="form-control">
                        <option value="">All Statuses</option>
                        <option value="pending" <?php echo $statusFilter === 'pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="approved" <?php echo $statusFilter === 'approved' ? 'selected' : ''; ?>>Approved</option>
                        <option value="rejected" <?php echo $statusFilter === 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                        <option value="completed" <?php echo $statusFilter === 'completed' ? 'selected' : ''; ?>>Completed</option>
                    </select>
                    <button type="submit" class="btn button-sm green">Filter</button>
                </form>
                <?php if (!$hasConsultancyTable): ?>
                    <p class="wam-empty-text">Table consultancy_requests was not found in the current database.</p>
                <?php elseif (empty($consultancyRows)): ?>
                    <p class="wam-empty-text">No consultancy requests found yet.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Request</th>
                                    <th>Organization</th>
                                    <th>Status</th>
                                    <th>Submitted</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($consultancyRows as $request): ?>
                                <tr>
                                    <td><?php echo sanitizeOutput($request['title']); ?></td>
                                    <td><?php echo sanitizeOutput($request['organization_name']); ?></td>
                                    <td><span class="btn button-sm <?php echo getStatusButtonClass($request['status']); ?>"><?php echo sanitizeOutput($request['status']); ?></span></td>
                                    <td><?php echo sanitizeOutput(date('M d, Y', strtotime($request['created_at']))); ?></td>
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

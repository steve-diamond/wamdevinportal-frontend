<?php
$pageTitle = 'Publications - WAMDEVIN Admin';
$pageDescription = 'Curate evidence and insights that shape regional practice';
$currentPage = 'publications';
$useCalendar = false;
$useCharts = false;
$useCounter = false;
$includeLegacyCSS = true;
$includeLegacyJS = true;

include('includes/admin-header.php');
include('includes/admin-sidebar.php');

$db = getDashboardConnection();
$publicationRows = [];
$hasPublicationsTable = false;
$search = isset($_GET['q']) ? trim($_GET['q']) : '';
$statusFilter = isset($_GET['status']) ? trim($_GET['status']) : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 10;
$pagination = buildPagination(0, $page, $perPage);
if ($db && adminTableExists($db, 'publications')) {
    $hasPublicationsTable = true;
    $where = [];
    $params = [];
    $titleExpr = adminColumnExists($db, 'publications', 'title') ? 'title' : "CONCAT('Publication #', id)";
    $hasStatus = adminColumnExists($db, 'publications', 'status');
    $statusExpr = $hasStatus ? 'status' : "'draft'";
    $dateExpr = adminColumnExists($db, 'publications', 'published_at') ? 'published_at' : (adminColumnExists($db, 'publications', 'created_at') ? 'created_at' : 'NOW()');
    if ($search !== '') {
        $where[] = "{$titleExpr} LIKE :q";
        $params[':q'] = '%' . $search . '%';
    }
    if ($statusFilter !== '' && $hasStatus) {
        $where[] = "status = :status";
        $params[':status'] = $statusFilter;
    }
    $whereSql = empty($where) ? '' : (' WHERE ' . implode(' AND ', $where));
    $total = (int)adminScalar($db, "SELECT COUNT(*) FROM publications{$whereSql}", $params, 0);
    $pagination = buildPagination($total, $page, $perPage);
    $publicationRows = adminRows($db, "SELECT {$titleExpr} AS title, {$statusExpr} AS status, {$dateExpr} AS published_at FROM publications{$whereSql} ORDER BY {$dateExpr} DESC LIMIT {$pagination['offset']}, {$pagination['perPage']}", $params);
}
?>

<main class="ttr-wrapper" id="main-content" role="main">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Publications</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
                <li>Publications</li>
            </ul>
        </div>

        <?php include('includes/admin-page-intro.php'); ?>

        <div class="widget-box">
            <div class="wc-title">
                <h4>Research Outputs</h4>
            </div>
            <div class="widget-inner">
                <p>Curate evidence that shapes policy, practice, and regional learning.</p>
                <ul>
                    <li>Submission review and editorial pipeline</li>
                    <li>Approval and publication scheduling</li>
                    <li>Distribution metrics and downloads</li>
                </ul>
            </div>
        </div>

        <div class="widget-box m-t20">
            <div class="wc-title">
                <h4>Recent Publications</h4>
            </div>
            <div class="widget-inner">
                <form method="get" class="form-inline m-b15" style="gap: 10px;">
                    <input type="text" name="q" class="form-control" placeholder="Search publication" value="<?php echo sanitizeOutput($search); ?>">
                    <select name="status" class="form-control">
                        <option value="">All Statuses</option>
                        <option value="published" <?php echo $statusFilter === 'published' ? 'selected' : ''; ?>>Published</option>
                        <option value="draft" <?php echo $statusFilter === 'draft' ? 'selected' : ''; ?>>Draft</option>
                        <option value="in_review" <?php echo $statusFilter === 'in_review' ? 'selected' : ''; ?>>In Review</option>
                    </select>
                    <button type="submit" class="btn button-sm green">Filter</button>
                </form>
                <?php if (!$hasPublicationsTable): ?>
                    <p class="wam-empty-text">Table publications was not found in the current database.</p>
                <?php elseif (empty($publicationRows)): ?>
                    <p class="wam-empty-text">No publication records found yet.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Published Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($publicationRows as $publication): ?>
                                <tr>
                                    <td><?php echo sanitizeOutput($publication['title']); ?></td>
                                    <td><span class="btn button-sm <?php echo getStatusButtonClass($publication['status']); ?>"><?php echo sanitizeOutput($publication['status']); ?></span></td>
                                    <td><?php echo sanitizeOutput(date('M d, Y', strtotime($publication['published_at']))); ?></td>
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

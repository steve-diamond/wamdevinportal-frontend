<?php
$pageTitle = 'Research Projects - WAMDEVIN Admin';
$pageDescription = 'Coordinate multi-country research that informs policy and governance';
$currentPage = 'research-projects';
$useCalendar = false;
$useCharts = false;
$useCounter = false;
$includeLegacyCSS = true;
$includeLegacyJS = true;

include('includes/admin-header.php');
include('includes/admin-sidebar.php');

$db = getDashboardConnection();
$projectRows = [];
$hasProjectsTable = false;
$search = isset($_GET['q']) ? trim($_GET['q']) : '';
$statusFilter = isset($_GET['status']) ? trim($_GET['status']) : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 10;
$pagination = buildPagination(0, $page, $perPage);
if ($db && adminTableExists($db, 'research_projects')) {
    $hasProjectsTable = true;
    $where = [];
    $params = [];
    $titleExpr = adminColumnExists($db, 'research_projects', 'title') ? 'title' : "CONCAT('Project #', id)";
    $hasStatus = adminColumnExists($db, 'research_projects', 'status');
    $statusExpr = $hasStatus ? 'status' : "'active'";
    $leadExpr = adminColumnExists($db, 'research_projects', 'lead_institution') ? 'lead_institution' : "'N/A'";
    $dateExpr = adminColumnExists($db, 'research_projects', 'start_date') ? 'start_date' : (adminColumnExists($db, 'research_projects', 'created_at') ? 'created_at' : 'NOW()');
    if ($search !== '') {
        $where[] = "{$titleExpr} LIKE :q";
        $params[':q'] = '%' . $search . '%';
    }
    if ($statusFilter !== '' && $hasStatus) {
        $where[] = "status = :status";
        $params[':status'] = $statusFilter;
    }
    $whereSql = empty($where) ? '' : (' WHERE ' . implode(' AND ', $where));
    $total = (int)adminScalar($db, "SELECT COUNT(*) FROM research_projects{$whereSql}", $params, 0);
    $pagination = buildPagination($total, $page, $perPage);
    $projectRows = adminRows($db, "SELECT {$titleExpr} AS title, {$leadExpr} AS lead_institution, {$statusExpr} AS status, {$dateExpr} AS start_date FROM research_projects{$whereSql} ORDER BY {$dateExpr} DESC LIMIT {$pagination['offset']}, {$pagination['perPage']}", $params);
}
?>

<main class="ttr-wrapper" id="main-content" role="main">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Research Projects</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
                <li>Research Projects</li>
            </ul>
        </div>

        <?php include('includes/admin-page-intro.php'); ?>

        <div class="widget-box">
            <div class="wc-title">
                <h4>Project Portfolio</h4>
            </div>
            <div class="widget-inner">
                <p>Coordinate multi-country research that informs policy and strengthens governance.</p>
                <ul>
                    <li>Milestones, risk, and partner alignment</li>
                    <li>Institution assignments and collaboration</li>
                    <li>Deliverables, reporting, and impact evidence</li>
                </ul>
            </div>
        </div>

        <div class="widget-box m-t20">
            <div class="wc-title">
                <h4>Recent Research Projects</h4>
            </div>
            <div class="widget-inner">
                <form method="get" class="form-inline m-b15" style="gap: 10px;">
                    <input type="text" name="q" class="form-control" placeholder="Search project" value="<?php echo sanitizeOutput($search); ?>">
                    <select name="status" class="form-control">
                        <option value="">All Statuses</option>
                        <option value="active" <?php echo $statusFilter === 'active' ? 'selected' : ''; ?>>Active</option>
                        <option value="completed" <?php echo $statusFilter === 'completed' ? 'selected' : ''; ?>>Completed</option>
                        <option value="planned" <?php echo $statusFilter === 'planned' ? 'selected' : ''; ?>>Planned</option>
                    </select>
                    <button type="submit" class="btn button-sm green">Filter</button>
                </form>
                <?php if (!$hasProjectsTable): ?>
                    <p class="wam-empty-text">Table research_projects was not found in the current database.</p>
                <?php elseif (empty($projectRows)): ?>
                    <p class="wam-empty-text">No research project records found yet.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Project</th>
                                    <th>Lead Institution</th>
                                    <th>Status</th>
                                    <th>Start Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($projectRows as $project): ?>
                                <tr>
                                    <td><?php echo sanitizeOutput($project['title']); ?></td>
                                    <td><?php echo sanitizeOutput($project['lead_institution']); ?></td>
                                    <td><span class="btn button-sm <?php echo getStatusButtonClass($project['status']); ?>"><?php echo sanitizeOutput($project['status']); ?></span></td>
                                    <td><?php echo sanitizeOutput(date('M d, Y', strtotime($project['start_date']))); ?></td>
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

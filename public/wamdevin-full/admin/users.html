<?php
$pageTitle = 'Users / Staff - WAMDEVIN Admin';
$pageDescription = 'Build a trusted admin community with clear roles and accountability';
$currentPage = 'users';
$useCalendar = false;
$useCharts = false;
$useCounter = false;
$includeLegacyCSS = true;
$includeLegacyJS = true;

include('includes/admin-header.php');
include('includes/admin-sidebar.php');

$db = getDashboardConnection();
$staffRows = [];
$hasAdminUsersTable = false;
$search = isset($_GET['q']) ? trim($_GET['q']) : '';
$statusFilter = isset($_GET['status']) ? trim($_GET['status']) : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 10;
$pagination = buildPagination(0, $page, $perPage);
if ($db && adminTableExists($db, 'admin_users')) {
    $hasAdminUsersTable = true;
    $where = [];
    $params = [];
    $nameExpr = adminColumnExists($db, 'admin_users', 'admin_name') ? 'admin_name' : "CONCAT('User #', id)";
    $emailExpr = adminColumnExists($db, 'admin_users', 'email') ? 'email' : "'N/A'";
    $roleExpr = adminColumnExists($db, 'admin_users', 'role') ? 'role' : "'staff'";
    $hasStatus = adminColumnExists($db, 'admin_users', 'status');
    $statusExpr = $hasStatus ? 'status' : "'active'";
    $dateExpr = adminColumnExists($db, 'admin_users', 'created_at') ? 'created_at' : 'NOW()';
    if ($search !== '') {
        $where[] = "({$nameExpr} LIKE :q OR {$emailExpr} LIKE :q)";
        $params[':q'] = '%' . $search . '%';
    }
    if ($statusFilter !== '' && $hasStatus) {
        $where[] = "status = :status";
        $params[':status'] = $statusFilter;
    }
    $whereSql = empty($where) ? '' : (' WHERE ' . implode(' AND ', $where));
    $total = (int)adminScalar($db, "SELECT COUNT(*) FROM admin_users{$whereSql}", $params, 0);
    $pagination = buildPagination($total, $page, $perPage);
    $staffRows = adminRows($db, "SELECT {$nameExpr} AS admin_name, {$emailExpr} AS email, {$roleExpr} AS role, {$statusExpr} AS status, {$dateExpr} AS created_at FROM admin_users{$whereSql} ORDER BY {$dateExpr} DESC LIMIT {$pagination['offset']}, {$pagination['perPage']}", $params);
}
?>

<main class="ttr-wrapper" id="main-content" role="main">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Users / Staff</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
                <li>Users / Staff</li>
            </ul>
        </div>

        <?php include('includes/admin-page-intro.php'); ?>

        <div class="widget-box">
            <div class="wc-title">
                <h4>User Directory</h4>
            </div>
            <div class="widget-inner">
                <p>Strengthen WAMDEVIN's mission by building a trusted leadership community with clear responsibilities, transparent governance, and consistent delivery standards.</p>
                <p class="wam-inline-note">Aligned to our vision of public sector excellence, every role reinforces collaboration, accountability, and regional impact.</p>
                <ul>
                    <li>Role-based access aligned to governance mandates</li>
                    <li>Onboarding, offboarding, and credential stewardship</li>
                    <li>Audit trails, activity monitoring, and compliance readiness</li>
                </ul>
            </div>
        </div>

        <div class="widget-box m-t20">
            <div class="wc-title">
                <h4>Admin Staff Directory</h4>
            </div>
            <div class="widget-inner">
                <form method="get" class="form-inline m-b15" style="gap: 10px;">
                    <input type="text" name="q" class="form-control" placeholder="Search name or email" value="<?php echo sanitizeOutput($search); ?>">
                    <select name="status" class="form-control">
                        <option value="">All Statuses</option>
                        <option value="active" <?php echo $statusFilter === 'active' ? 'selected' : ''; ?>>Active</option>
                        <option value="inactive" <?php echo $statusFilter === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                        <option value="suspended" <?php echo $statusFilter === 'suspended' ? 'selected' : ''; ?>>Suspended</option>
                    </select>
                    <button type="submit" class="btn button-sm green">Filter</button>
                </form>
                <?php if (!$hasAdminUsersTable): ?>
                    <p class="wam-empty-text">Table admin_users was not found in the current database.</p>
                <?php elseif (empty($staffRows)): ?>
                    <p class="wam-empty-text">No admin staff records found yet.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($staffRows as $staff): ?>
                                <tr>
                                    <td><?php echo sanitizeOutput($staff['admin_name']); ?></td>
                                    <td><?php echo sanitizeOutput($staff['email']); ?></td>
                                    <td><?php echo sanitizeOutput($staff['role']); ?></td>
                                    <td><span class="btn button-sm <?php echo getStatusButtonClass($staff['status']); ?>"><?php echo sanitizeOutput($staff['status']); ?></span></td>
                                    <td><?php echo sanitizeOutput(date('M d, Y', strtotime($staff['created_at']))); ?></td>
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
